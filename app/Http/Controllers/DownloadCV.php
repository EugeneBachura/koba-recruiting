<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Candidate;


class DownloadCV extends Controller
{
    /**
     * Download the CV.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadById($id)
    {
        $candidate = Candidate::where('id', $id)->first();
        $format = substr($candidate->cv, strrpos($candidate->cv, '.'));
        $file_name = $candidate->first_name . '_' . $candidate->last_name . $format;
        return Storage::download($candidate->cv, $file_name);
    }
}
