<?php

namespace App\Console\Commands\Translations;

use Illuminate\Console\Command;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:update {sourcelanguage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans the source (HTML, JS, PHP) for translateable strings and updates the catalogs';

    /**
     * @var array
     */
    protected $sourcePaths = ['/angular', '/app'];

    /**
     * @var array
     */
    protected $observedFileExtensions = ['.html', '.js', '.php', '.phtml'];

    /**
     * @var string
     */
    protected $baseDir;

    /**
     * @var string
     */
    protected $catalogDir;

    /**
     * @var string
     */
    protected $translationsDir;

    protected $supportedLanguages = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->baseDir = realpath(__DIR__ . '/../../../../');
        $this->translationsDir = $this->baseDir . '/resources/translations/';
        $this->catalogDir = $this->translationsDir . '/catalogs/';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sourceLanguage = $this->argument('sourcelanguage');

        if (!file_exists($this->translationsDir)) {
            $this->info(sprintf('Created translations directory %1$s', $this->translationsDir));
            mkdir($this->translationsDir);
        }

        if (!file_exists($this->catalogDir)) {
            $this->info(sprintf('Created catalog directory %1$s', $this->catalogDir));
            mkdir($this->catalogDir);
        }

        $strings = $this->extractStrings();
        $this->info(sprintf('Found %1$s strings', count($strings)));

        $strings = $this->removeDuplicateStrings($strings);
        $this->info(sprintf('Found %1$s strings (without duplicates)', count($strings)));

        $potFile = $this->translationsDir . '/newhere.pot';
        $this->createPot($sourceLanguage, $strings, $potFile);
        $this->info(sprintf('POT file written to %1$s', $potFile));

        $languages = array_diff(scandir($this->catalogDir), ['.', '..', '.svn', '.git']);
        foreach ($languages as $idx => $language) {
            if (preg_match('/^([a-z_-]+)\.po$/', $language, $matches)) {
                $languages[$idx] = $matches[1];
            } else {
                unset($languages[$idx]);
            }
        }
        $this->supportedLanguages = $languages;
        $this->info(sprintf('Will update catalogs for languages: %1$s', implode(', ', $this->supportedLanguages)));
        foreach ($this->supportedLanguages as $language) {
            $this->updatePo($this->catalogDir . '/' . $language . '.po', $potFile);
        }

        $this->info('Update finished. Bye, bye.');
    }

    private function extractStrings() {
        $strings = [];

        foreach ($this->sourcePaths as $path) {
            $fullPath = realpath($this->baseDir . '/' . $path);
            $this->info(sprintf('Scanning %1$s...', $fullPath));

            $fileList = $this->generateFileList($fullPath);

            foreach ($fileList as $file) {
                $strings = array_merge($strings, $this->parseFile($file));
            }
        }

        return $strings;
    }

    private function generateFileList($path) {
        $fileList = [];

        $items = array_diff(scandir($path), ['.', '..', '.svn', '.git']);
        foreach ($items as $item) {
            $itemPath = $path . '/' . $item;
            if (is_dir($itemPath)) {
                $fileList = array_merge($fileList, $this->generateFileList($itemPath));
            } else {
                foreach ($this->observedFileExtensions as $extension) {
                    if (preg_match("/(.*){$extension}$/", $item)) {
                        $fileList[] = $itemPath;
                        break;
                    }
                }
            }
        }

        return $fileList;
    }

    private function parseFile($file) {
        $content = file_get_contents($file);

        $strings = [];

        if (preg_match_all('/{{\s*(\'|")(.*)(\'|")\s*\|\s*translate(:\s*\{(.*)\}|\\\\|(.*))?\s*}}/', $content, $matches)) {
            $strings = array_merge($strings, $matches[2]);
        }

        if (preg_match_all('/ng-bind-html="\s*(\'|")(.*)(\'|")\s*\|\s*translate(:\s*\{(.*)\}|\\\\|(.*))?\s*"/', $content, $matches)) {
            $strings = array_merge($strings, $matches[2]);
        }

        if (preg_match_all('/\$translate\((\'|")(.*)(\'|")(,(.*))*\)/', $content, $matches)) {
            $strings = array_merge($strings, $matches[2]);
        }

        if (preg_match_all('/__\((\'|")(.*)(\'|")\)/', $content, $matches)) {
            $strings = array_merge($strings, $matches[2]);
        }

        foreach ($strings as $idx => $string) {
            $string = str_replace('\\', '\\\\"', $string);
            $strings[$idx] = str_replace('"', '\"', $string);
        }

        return ($strings ? [$file => $strings] : []);
    }

    private function removeDuplicateStrings($strings) {
        $knownStrings = [];
        foreach ($strings as $file => $containedStrings) {
            foreach ($containedStrings as $idx => $containedString) {
                $hash = md5($containedString);
                if (isset($knownStrings[$hash])) {
                    unset($containedStrings[$idx]);
                } else {
                    $knownStrings[$hash] = $containedString;
                }
            }

            if (!$containedStrings) {
                unset($strings[$file]);
            } else {
                $strings[$file] = $containedStrings;
            }
        }

        unset($knownStrings);

        return $strings;
    }

    private function createPot($sourceLocale, $strings, $potFile) {
        $headers = [
            'msgid ""',
            'msgstr ""',
            '"Project-Id-Version: Newhere\n"',
            '"POT-Creation-Date: ' . date('Y-m-d H:i:sO') . '\n"',
            '"PO-Revision-Date: ' . date('Y-m-d H:i:sO') . '\n"',
            '"Language: ' . $sourceLocale . '\n"',
            '"MIME-Version: 1.0\n"',
            '"Content-Type: text/plain; charset=UTF-8\n"',
            '"Content-Transfer-Encoding: 8bit\n"',
            '',
            ''
        ];
        $headers = implode("\n", $headers);

        $output = [];
        foreach ($strings as $file => $containedStrings) {
            foreach ($containedStrings as $containedString) {
                $tmp = [
                    '#: ' . $file,
                    'msgid "' . $containedString . '"',
                    'msgstr ""',
                    ''
                ];
                $output[] = implode("\n", $tmp);
            }
        }
        $output = implode("\n", $output);

        file_put_contents($potFile, ($headers . $output));
    }

    private function updatePo($poFile, $potFile)
    {
        $tmpFile = str_replace('.po', '.po.tmp', $poFile);
        $cmd = sprintf('msgmerge --force-po --silent -N %1$s %2$s -o %3$s', $poFile, $potFile, $tmpFile);
        $this->info(sprintf('Will execute command: %1$s', $cmd));
        shell_exec($cmd);

        if (file_exists($tmpFile)) {
            copy($tmpFile, $poFile);
            unlink($tmpFile);
        }
        $this->info(sprintf('Updated catalog %1$s', $poFile));
    }
}
