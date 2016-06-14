<?php

namespace App\Console\Commands\Translations;

use Illuminate\Console\Command;

class NewLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:newlanguage {language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the PO stub for a new translation catalog';

    /**
     * @var string
     */
    protected $catalogDir;

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $language = $this->argument('language');

        if (!file_exists($this->catalogDir)) {
            $this->error(sprintf('Catalog Directory %1$s does not exist.', $this->catalogDir));
            return;
        }

        $catalogDir = sprintf('%1$s/%2$s', $this->catalogDir, $language);
        if (file_exists($catalogDir)) {
            $this->error(sprintf('Language directory already exists: %1$s', $catalogDir));
            return;
        } else {
            mkdir($catalogDir);
        }
        
        $poFile = sprintf('%1$s/%2$s/newhere.po', $this->catalogDir, $language);
        if (file_exists($poFile)) {
            $this->error(sprintf('PO catalog for language %1$s already exists: %2$s', $language, $poFile));
            return;
        }

        $this->writePo($language, $poFile);
        $this->info(sprintf('New PO catalog for language %1$s written to %2$s', $language, $poFile));
        $this->info('Please update the catalogs!');
    }

    private function writePo($language, $poFile)
    {
        $content = sprintf('msgid ""
msgstr ""
"Project-Id-Version: New Here\n"
"Report-Msgid-Bugs-To: info@newhere.at\n"
"POT-Creation-Date: %1$s\n"
"PO-Revision-Date: %1$s\n"
"Last-Translator: Automatically generated\n"
"Language-Team: none\n"
"Language: %2$s\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"Plural-Forms: nplurals=2; plural=(n != 1);\n"',
            date('Y-m-d H:i:sO'),
            $language
        );

        file_put_contents($poFile, $content);
    }
}
