<?php

namespace PrestoPlayer\Integrations\Tutor;

class Tutor
{
    public function register()
    {
        add_filter('tutor_course/single/video', [$this, 'renderVideo']);
        add_filter('tutor_lesson/single/video', [$this, 'renderVideo']);
    }

    public function renderVideo($output)
    {
        if (!strpos($output, '[presto_player')) {
            return $output;
        }
        // read all image tags into an array
        preg_match_all('/<source[^>]+>/i', $output, $source);

        if (empty($source[0])) {
            return $output;
        }

        preg_match('/src="([^"]+)/i', $source[0][0], $src);

        if (empty($src[1])) {
            return $output;
        }

        return \do_shortcode($src[1]);
    }
}
