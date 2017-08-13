<?php

namespace sacep\Http\Controllers;

use Illuminate\Support\Facades\View;
use \Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PdfController extends Controller
{
	public function invoice()
	{
		$data = $this->getData();
		$date = date('Y-m-d');
		$invoice = "2222";
		$view =  View::make('invoice', compact('data', 'date', 'invoice'))->render();
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream('invoice');
	}

	public function getData()
	{
		$data =  [
			'quantity'      => '1' ,
			'description'   => 'some ramdom text',
			'price'   => '500',
			'total'     => '500'
		];
		return $data;
	}

	public function import_csv_view()
	{
		return view('file');
	}

	public function import_csv_post(Request $request)
	{
		$file = $request->file('archivo');

		//Display File Name
      echo 'File Name: '.$file->getClientOriginalName();
      echo '<br>';

      //Display File Extension
      echo 'File Extension: '.$file->getClientOriginalExtension();
      echo '<br>';

      //Display File Real Path
      echo 'File Real Path: '.$file->getRealPath();
      echo '<br>';

      //Display File Size
      echo 'File Size: '.$file->getSize();
      echo '<br>';

      //Display File Mime Type
      echo 'File Mime Type: '.$file->getMimeType();

		Excel::load($file,function($reader){
			foreach ($reader->get() as $read) {
				echo $read->title."<br>";
			}
		});

	}
}
