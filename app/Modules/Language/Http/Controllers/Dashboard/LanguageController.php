<?php

namespace Modules\Language\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;
use Modules\Language\Models\Language;

class LanguageController extends Controller
{
    /**
     * assign roles.
     */
    public function __construct()
    {
        $this->middleware('can:view_languages', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_languages', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_languages', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_languages', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change_locale($code)
    {
        $language = Language::where('code', $code)->first();
        if ($language) {
            session()->put('locale', $code);
            session()->put('rtl', $language['rtl']);
            session()->forget('trans');
        }

        return redirect()->back();
    }

    public function index()
    {
        return view('Language::admin.index');
    }

    public function listData()
    {

        $Languages = Language::orderBy('created_at', 'desc')->get();

        $no = 0;
        $data = [];
        foreach ($Languages as $Language) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $Language->name;
            $row[] = $Language->code;
            $row[] = $Language->direction;
            $row[] = $Language->active ? '<span class="badge bg-soft-success text-success">'.t_('Active').'</span>' : '<span class="badge bg-soft-danger text-danger">'.t_('Blocked').'</span>';
            $row[] = '<img src="'.asset('storage/'.$Language->flag).'" style="width: 60px">';
            $row[] = '<a href="javascript:void(0);" onclick="editForm('.$Language->id.')" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                      <a href="javascript:void(0);" onclick="deleteData('.$Language->id.')" class="action-icon"> <i class="mdi mdi-delete"></i></a>
               ';
            $data[] = $row;
        }

        $output = ['data' => $data];

        return response()->json($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Language a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $curLang = Language::get();
        $Col = $curLang->count();

        if ($request['active']) {
            $active = 1;
        } else {
            $active = 0;
        }

        $lang = new Language();
        $lang->name = $request['Name'];
        $lang->local = $request['Local'];
        $lang->code = $request['Code'];
        $lang->direction = $request['Direction'];
        $lang->active = $active;
        $lang->sort = $request['Sort'];
        $lang->col = $Col + 1;

        if ($request->hasFile('flag')) {

            $str = rand();
            $result = md5($str);
            $file = $request['flag'];
            $file_name = $result.$file->getLanguageOriginalName();
            $file->move(base_path().'/public/storage/lanugage/'.$request->name, $file_name);
            $Flag = 'lanugage/'.$request->phone.'/'.$file_name;
            $lang->flag = $Flag;
        }

        $lang->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $language = User::find($id);
        echo json_encode($language);
    }

    public function update(Request $request)
    {
        $id = $request['client_id'];
        $language = User::find($id);
        $language->name = $request['client_name'];

        if ($request->hasFile('Logo')) {

            $str = mt_rand();
            $result = md5($str);
            $file = $request['Logo'];
            $file_name = $result.$file->getLanguageOriginalName();
            $file->move(base_path().'/public/storage/clients/'.$request->client_name, $file_name);
            $Logo = 'clients/'.$request->client_name.'/'.$file_name;
            $language->logo = $Logo;
        }

        $language->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy($language)
    {
        $language = User::find($language);
        $language->delete();
    }
}
