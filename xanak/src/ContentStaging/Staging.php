<?php

namespace Xanak\ContentStaging;

class Staging
{
    protected $stagedContent = [];

    protected $stagingDir;

    public function __construct()
    {
        $this->stagingDir = __DIR__ . '/../../../storage/staging';
    }

    public function saveDraft($filename, $content)
    {
        file_put_contents($this->stagingDir . '/' . $filename, $content);
    }

    public function getDraft($filename)
    {
        $file = $this->stagingDir . '/' . $filename;
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        return null;
    }

    public function publish($filename)
    {
        $draft = $this->getDraft($filename);
        if ($draft) {
            file_put_contents(__DIR__ . '/../../../storage/live/' . $filename, $draft);
            unlink($this->stagingDir . '/' . $filename);
        }
    }

    public function stage($content)
    {
        $this->stagedContent[] = $content;
    }

    // public function publish()
    // {
    //     foreach ($this->stagedContent as $content) {
    //         // Implement publishing logic
    //     }

    //     // Clear staged content after publishing
    //     $this->stagedContent = [];
    // }
}
