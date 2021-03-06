<?php 
namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;
use App\Helpers\Utilities as Utils;
use App\Helpers\FileHelper;
use App\Helpers\Response;
use Illuminate\Http\Response as LaraResponse;

class DifficultyController extends Controller {

    public $weeksPDFPath = 'app/public/difficulty/';
    protected $poppler;
    protected $weeks = [];
    protected $powers = [];
    protected $feathers = [];
    protected $horses = [];
    protected $furs = [];
    protected $truffles = [];
    protected $milks = [];
    protected $wools = [];
    protected $eggs = [];
    protected $assets = [];
    protected $weeksData = [];

    public function __construct()
    {
        $this->poppler = env('APP_ENV') == 'production' 
            ? '/app/bin/pdftotext' : '/usr/bin/pdftotext';
        $this->FileHelper = new FileHelper;
    }

    public function getDifficultyData()
    {
        $fullPath = getcwd() . '/difficulty/';
        $file = 'week.txt';
        $log = $this->FileHelper->readFile($fullPath, $file);
        return $this->sendResponse($log);
    }

    public function getPdfExtractAssets()
    {
        $fullPath = getcwd() . '/difficulty/';
        $file = 'assets.txt';
        $log = $this->FileHelper->readFile($fullPath, $file);
        return $this->sendResponse($log);
    }

    private function sendResponse($data)
    {
        return response(isset($data[0]) ? json_decode($data[0]) : [], 200);
    }

    public function difficultyData()
    {
        $this->pdfExtractWeeks();
        $fullPath = getcwd() . '/difficulty/';
        $this->FileHelper->writeFile($fullPath, 'week.txt', json_encode($this->weeksData));
    }

    public function pdfExtractAssets()
    {
        // $fullPath = storage_path($this->weeksPDFPath . 'extracts.pdf');
        $fullPath = getcwd() . '/difficulty/'. 'extracts.pdf';
        if(file_exists($fullPath)){
            $result = (new Pdf($this->poppler))->setPdf($fullPath)->text();
            $contents = $this->getLines($result);
            $this->extractAssets($contents);
            $this->restructureAssets();
        }
        $fullPath = getcwd() . '/difficulty/';
        $this->FileHelper->writeFile($fullPath, 'assets.txt', json_encode($this->assets));
        // Response::responseJSON($this->assets);
    }

    public function restructureAssets()
    {
        $asset = [];
        foreach($this->weeks as $key => $week){
            $weekChunk = explode(' ', $week);
            $asset['min_week'] = isset($weekChunk[1]) 
                ? str_replace('-', '', $weekChunk[1]) : '';
            $asset['max_week'] = isset($weekChunk[2]) 
                ? str_replace('-', '', $weekChunk[2]) : '';
            $asset['power'] = $this->powers[$key] ?? '';
            $asset['feather'] = $this->feathers[$key] ?? '';
            $asset['horse_hair'] = $this->horses[$key] ?? '';
            $asset['fur'] = $this->furs[$key] ?? '';
            $asset['truffle'] = $this->truffles[$key] ?? '';
            $asset['milk'] = $this->milks[$key] ?? '';
            $asset['wool'] = $this->wools[$key] ?? '';
            $asset['eggs'] = $this->eggs[$key] ?? '';
            array_push($this->assets, $asset);
        }
    }

    public function extractAssets($contents)
    {
        foreach($contents as $content){
            if(str_contains($content, 'Week')){
                array_push($this->weeks, $content);
            }
            if(str_contains($content, 'Power')){
                array_push($this->powers, $this->disectItem($content));
            }
            if(str_contains($content, 'Feather')){
                array_push($this->feathers, $this->disectItem($content));
            }

            if(str_contains($content, 'Horse')){
                array_push($this->horses,  $this->disectItem($content));
            }
            if(str_contains($content, 'Fur')){
                array_push($this->furs, $this->disectItem($content));
            }
            if(str_contains($content, 'Truffles')){
                array_push($this->truffles, $this->disectItem($content));
            }

            if(str_contains($content, 'Milk')){
                array_push($this->milks, $this->disectItem($content));
            }
            if(str_contains($content, 'Wool')){
                array_push($this->wools, $this->disectItem($content));
            }
            if(str_contains($content, 'Egg')){
                array_push($this->eggs, $this->disectItem($content));
            }
        }
    }

    private function disectItem($item)
    {
        $item = explode(' ', trim($item));
        return reset($item);
    }

    private function removeExtractLines($contents)
    {
        $removeIndexes = [
            0, 229
        ];
        $contents = $this->removeLines($contents, $removeIndexes);
    }

    public function pdfExtractWeeks()
    {
        $data = [];
        // $fullPath = storage_path($this->weeksPDFPath . 'weeks.pdf');
        $fullPath = getcwd() . '/difficulty/'. 'weeks.pdf';
        if(file_exists($fullPath)){
            
            $result = (new Pdf($this->poppler))->setPdf($fullPath)->text();
            $contents = $this->getLines($result);
            $removeIndexes = [
                0,1,2,3,4,5,6,7,8, 
                241,242,243,244,245,246,247,248,249,
                482,483,484,485,486, 563
            ];
            $contents = $this->removeLines($contents, $removeIndexes);
            $data = $this->restructureData($contents);
        }
        $this->weeksData = $data;
        // Response::responseJSON($data);
    }

    public function restructureData($contents)
    {
        $output = [];
        $weeks = [];
        $values = [];
        foreach($contents as $content){
            if( strlen( trim($content) ) > 5){
                array_push($values, str_replace(',','',$content));
            }else{
                array_push($weeks, $content);
            }
        }
        foreach($weeks as $key => $week){
            $item = [
                'week' => $week,
                'value' => $values[$key]
            ];
            array_push($output, $item);
        }
        return $output;
    }

    public function removeLines($contents, $removeIndexes)
    {
        
        foreach($contents as $key => $item){
            if(in_array($key, $removeIndexes)){
                unset($contents[$key]);
            }
        }
        return $contents;
    }

    public function getLines($content)
    {
        $lines = Utils::splitByLine($content);
        $lines = Utils::removeEmptyLines($lines);
        return $lines;
    }

    public function moveFiles()
    {
        $files = ['extracts.pdf', 'weeks.pdf'];
        foreach($files as $file){
            $fullPath = getcwd() . '/difficulty/'.$file;
            $new = storage_path($this->weeksPDFPath).$file;
            if(file_exists($fullPath)){
                dump($new);
                dump(rename($fullPath, $new));
            }
        }
    }
}