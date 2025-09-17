<?php

if ( !class_exists('App_Version') ) {

    final class App_Version
    {
        private static string $version = '';
        private static string $version_with_commit = '';
        private static bool $is_initialized = false;

        private static function init(): void
        {
            if (self::$is_initialized) return;
            self::setNsiAppVersionFromVersionsFile();
        }

        public static function get_app_version($version_type): string
        {
            self::init();
            //TODO: refactor into enum after upgrade to php8.1
            return $version_type == 'FULL' ? self::$version_with_commit : self::$version;
        }


        private static function setNsiAppVersionFromVersionsFile(): void
        {
            $versions = self::parse_file_to_array(self::get_file_path_for_win_or_lin());
            if (!empty($versions) && count($versions) > 1) {
                self::$version_with_commit = $versions[0] . '_' . $versions[1];
                self::$version = $versions[0];
                self::$is_initialized = true;
            }
        }

        private static function parse_file_to_array($file_path): array
        {
            if (!file_exists($file_path)) {
                return [];
            }
            $array_from_file = file($file_path);
            $lines = [];
            if (!empty($array_from_file)) {
                foreach($array_from_file as $line) {
                    $line_handled = str_replace("\r\n'", '', $line);
                    $lines[] = $line_handled;
                }
            }

            return $lines;
        }

        /**
         * handling file path based on the OS installed
         * @return string
         */
//        TODO: extract to common Helpers
        public static function get_file_path_for_win_or_lin(): string
        {
            $file_path = get_theme_root() . '/' . get_template() . '/classes/vars.txt';
            return substr($file_path, 1, 2) == ':\\' ? str_replace('/', '\\', $file_path,) : $file_path;
        }
    }

}
