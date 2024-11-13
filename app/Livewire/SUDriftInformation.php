<?php

namespace App\Livewire;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;

class SUDriftInformation extends Component
{
    public $rssItems = [];
    public $limit = 3;  // Limit the number of items displayed

    public function mount()
    {
        $this->fetchRssFeed();
    }

    public function fetchRssFeed()
    {
        /** @var
         * Handle both RSS and Atom feeds
         *
         */

        $client = new Client();

        try {
            $response = $client->get($this->su_it());
            $rssContent = $response->getBody()->getContents();

            // Initialize DOMDocument and load the XML
            $dom = new \DOMDocument();
            @$dom->loadXML($rssContent); // Suppress errors with @

            // Get the feed type: RSS or Atom
            $isRSS = $dom->getElementsByTagName('channel')->length > 0;
            $isAtom = $dom->getElementsByTagName('feed')->length > 0;

            $rssItems = [];

            // Handle RSS feeds
            if ($isRSS) {
                $items = $dom->getElementsByTagName('item'); // Get RSS items
                foreach ($items as $item) {
                    $title = $item->getElementsByTagName('title')->item(0)->nodeValue;
                    $link = $item->getElementsByTagName('link')->item(0)->nodeValue;
                    $pubDate = $item->getElementsByTagName('pubDate')->item(0)->nodeValue;
                    $description = $item->getElementsByTagName('description')->item(0)->nodeValue;

                    $rssItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'pubDate' => Carbon::parse($pubDate)->format('D, d M Y'),
                        'description' => $description,
                    ];
                }
            }

            // Handle Atom feeds
            elseif ($isAtom) {
                $entries = $dom->getElementsByTagName('entry'); // Get Atom entries
                foreach ($entries as $entry) {
                    $title = $entry->getElementsByTagName('title')->item(0)->nodeValue;
                    $link = $entry->getElementsByTagName('link')->item(0)->getAttribute('href');
                    $updated = $entry->getElementsByTagName('updated')->item(0)->nodeValue;
                    $summary = $entry->getElementsByTagName('summary')->item(0)->nodeValue;

                    $rssItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'pubDate' => Carbon::parse($updated)->format('D, d M Y'),
                        'description' => $summary,
                    ];
                }
            }

            // Limit the number of items
            $this->rssItems = collect($rssItems)->take($this->limit);

        } catch (\Exception $e) {
            // Log the error and clear items on failure
            logger('Error fetching feed: ' . $e->getMessage());
            $this->rssItems = [];
        }
    }

    public function render()
    {
        return view('livewire.s-u-drift-information');
    }

    private function su_it()
    {
        $this->file = base_path() . '/systemconfig/internt.ini';
        if (!file_exists($this->file)) {
            $this->file = base_path() . '/systemconfig/internt.ini.example';
        }
        $this->system_config = parse_ini_file($this->file, true);

        return $this->system_config['rss']['su_drift'];
    }
}
