<?php

namespace App\Http\Controllers;

use App\Repositories\MapRepository;
use Illuminate\Http\Request;

class MapController extends Controller
{
    protected $repository;

    public function __construct(MapRepository $repository)
    {
        $this->repository = $repository;
    }

    public function mapHandler(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'url' => 'required|url',
            ]);

//            dd($request->all());

            $result = $this->repository->handle($request);

            if (!empty($result['error'])) {
                echo json_encode($result);
                die();
            }

            if (isset($result['urls']) && count($result['urls']) > 0) {
                $urls = view('map.urls')->with(['urls' => $result['urls']])->render();
                echo json_encode(['success' => $urls, 'nums' => $result['nums']]);
                die;
            }

            echo json_encode(['success' => '', 'nums' => $result['nums']]);
            die;
        }

//        dd('-----------map----------------');
        return view('map.show')->render();
    }

    public function sum(array &$val)
    {
        foreach ($val as $k => $v) {
            $val[$k] = $v + 1;
        }

        return $val;
    }
}
