<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use Illuminate\Http\Request;
use App\Http\Requests\BarcodeRequest;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barcode');
    }


    /**
     * Generate Barcode in .png file extension. This operation is necessary to generate .webp file.
     * BarcodeGeneratorPNG library does not support .webp extension.
     *
     * @param  Request $request
     * @return string $path
     */
    public function generatePngBarcode(Request $request)
    {
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG ();
        $path = sprintf("%s.png", time());
        $generatorConst = constant($generator::class . '::' . $request->barcode_type);
        try{
            $result = $generator->getBarcode($request->barcode_text, $generatorConst, (int)$request->barcode_width, (int)$request->barcode_height, [0, 0, 0]);
            file_put_contents($path, $result);
        } catch(\Exception | \TypeError $e) {
            return $e;
        }
        return $path;
    }

    /**
     * Generate .webp barcode from existing .png file
     *
     * @param  Request $request
     * @return void
     */
    public function generateWebpBarcode(BarcodeRequest $request)
    {
        $barcodePng = $this->generatePngBarcode($request);
        if(!is_string($barcodePng)) {
            return back()->withError("Wprowadzono błędne dane. Wprowadź kod kreskowy w odpowiednim formacie.")->withInput();
        }

        $img = imagecreatefrompng($barcodePng);
        imagepalettetotruecolor($img);
        $fileNameWebp = str_replace("png", "webp", $barcodePng);
        $file = imagewebp($img, $fileNameWebp, 100);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header(sprintf('Content-Disposition: attachment; filename="%s"',  basename($fileNameWebp)));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileNameWebp));
        flush();

        /* Remove previously generated files after download result file*/
        if(readfile($fileNameWebp)){
          unlink($fileNameWebp);
          unlink($barcodePng);
        }
    }

}
