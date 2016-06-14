<?php

namespace App\Console\Commands\Translations;

use Illuminate\Console\Command;

class Compile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compiles the translated catalogs and prepares JSON-files for angular-translate';

    /**
     * @var string
     */
    protected $catalogDir;

    /**
     * @var string
     */
    protected $publicDir;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $baseDir = realpath(__DIR__ . '/../../../../');
        $this->catalogDir = $baseDir . '/resources/translations/catalogs/';
        $this->publicDir = $baseDir . '/public/translations/';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!file_exists($this->catalogDir)) {
            $this->error(sprintf('Catalog Directory %1$s does not exist.', $this->catalogDir));
            return;
        }

        if (!file_exists($this->publicDir)) {
            $this->info(sprintf('Created public translations directory %1$s', $this->publicDir));
            mkdir($this->publicDir);
        }

        $languages = array_diff(scandir($this->catalogDir), ['.', '..', '.svn', '.git']);
        foreach ($languages as $idx => $language) {
            if (preg_match('/^([a-z_-]+)$/', $language, $matches)) {
                $poFile = sprintf('%1$s/%2$s/newhere.po', $this->catalogDir, $matches[1]);
                $this->compilePo($poFile);
                $this->info(sprintf('PO catalog for language %1$s compiled', $matches[1]));

                $jsonFile = sprintf('%1$s/%2$s.json', $this->publicDir, $matches[1]);
                $this->generateJson($matches[1], $poFile, $jsonFile);
                $this->info(sprintf('JSON for language %1$s generated', $matches[1]));
            }
        }

        $this->info('Everything done. Bye, bye.');
    }

    private function compilePo($poFile)
    {
        $moFile = str_replace('.po', '.mo', $poFile);

        $cmd = sprintf('msgfmt -o %1$s %2$s', $moFile, $poFile);
        $this->info(sprintf('Will execute command: %1$s', $cmd));

        shell_exec($cmd);
    }

    private function generateJson($language, $poFile, $jsonFile)
    {
        $cmd = sprintf('i18next-conv -l %1$s -s %2$s -t %3$s', $language, $poFile, $jsonFile);
        $this->info(sprintf('Will execute command: %1$s', $cmd));

        shell_exec($cmd);

        $jsonContent = file_get_contents($jsonFile);
        $jsonContent = json_decode($jsonContent, true);
        foreach ($jsonContent as $key => $value) {
            if (!$value) {
                unset($jsonContent[$key]);
            }
        }

        file_put_contents($jsonFile, json_encode($jsonContent));
    }
}
