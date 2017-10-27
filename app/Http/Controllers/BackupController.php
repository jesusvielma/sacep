<?php

namespace sacep\Http\Controllers;

// use Artisan;
use Illuminate\Support\Facades\Artisan;
use Exception;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
    }

    public function index()
    {
        if (!count(config('laravel-backup.backup.destination.disks'))) {
            dd(trans('backpack::backup.no_disks_configured'));
        }

        $this->data['backups'] = [];

        foreach (config('laravel-backup.backup.destination.disks') as $disk_name) {
            $disk = Storage::disk($disk_name);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();

            // make an array of backup files, with their filesize and creation date
            foreach ($files as $k => $f) {
                // only take the zip files into account
                if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                    $this->data['backups'][] = [
                        'file_path'     => $f,
                        'file_name'     => str_replace('backups/', '', $f),
                        'file_size'     => $disk->size($f),
                        'last_modified' => $disk->lastModified($f),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof Local) ? true : false,
                        ];
                }
            }
        }

        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';

        return view('backup.index', $this->data);

    }

    public function create()
    {
        try {
            ini_set('max_execution_time', 500);
            // start the backup process
            //Artisan::call('backup:run --filename=$(date "+%Y-%m-%d-%H-%M-%S").zip --only-db ');
            Artisan::call('backup:run',[
                '--filename'=> date('Y-m-d-H-i-s').'.zip',
                '--only-db' => true
            ]);
            $output = Artisan::output();


            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n".$output);
            // return the results as a response to the ajax call
            //echo $output;
        } catch (Exception $e) {
            Response::make($e->getMessage(), 500);
        }

        return redirect()->route('backup');
    }

    /**
     * Downloads a backup zip file.
     */
    public function download()
    {
        $disk = Storage::disk(Request::input('disk'));
        $file_name = Request::input('file_name');
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                abort(404, trans('backpack::backup.backup_doesnt_exist'));
            }
        } else {
            abort(404, trans('backpack::backup.only_local_downloads_supported'));
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $disk = Storage::disk(Request::input('disk'));

        if ($disk->exists($file_name)) {
            $disk->delete($file_name);

            return redirect()->route('backup');
        } else {
            abort(404, trans('backpack::backup.backup_doesnt_exist'));
        }
    }
}
