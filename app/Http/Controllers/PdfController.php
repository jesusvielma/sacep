<?php

namespace sacep\Http\Controllers;

use Illuminate\Support\Facades\View;
use \Illuminate\Support\Facades\App;

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
}
