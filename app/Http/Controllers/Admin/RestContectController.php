<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Restaurant;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

use App\Table;
use App\Menu;

class RestContectController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $restaurants = $admin->restaurants;

        $restaurant_id = $request->id;
        $selRest = $admin->restaurants()->where('id', $restaurant_id)->first();
        // $selRest = Restaurant::find($restaurant_id);

        if ($selRest == null) return redirect('admin/404');
        
        return view('admin.restcontent', compact('restaurants', 'selRest'));
    }

    public function getTable(Request $request)
    {
        $restaurant_id = $request->id;
        $restName = Restaurant::find($restaurant_id)->restName;
        $tables = Restaurant::find($restaurant_id)->tables()->orderBy('tableNum')->get();

        $record = array();
        $res['data'] = [];

        foreach ($tables as $table) {
            $record['tableNum'] = $table->tableNum;
            $record['restName'] = $restName;
            $record['qrImgUrl'] = $table->qrImgUrl;

            $res['data'][] = $record;
        }
        
        $res['recordsTotal'] = count($tables);
        $res['recordsFiltered'] = count($tables);

        return response()->json($res, 200);
    }

    public function addTable(Request $request)
    {
        $restaurant_id = $request->id;

        $newTableNum = 1;
        if (Restaurant::find($restaurant_id)->tables()->count() > 0) {
            $lastTableNumber = Restaurant::find($restaurant_id)->tables()->orderByDesc('tableNum')->first()->tableNum;
            $newTableNum = $lastTableNumber + 1;
        }
        
        $qrStr = $restaurant_id.','.$newTableNum;

        $qrImgUrl = $this->generateQrCode($qrStr);

        $table = new Table;

        $table->tableNum = $newTableNum;
        $table->restaurant_id  = $restaurant_id;
        $table->qrImgUrl = $qrImgUrl;

        $table->save();

        $res = array();
        $res['status'] = 1;

        return response()->json($res, 200);
    }

    protected function generateQrCode($str)
    {
        // Create a basic QR code
        $qrCode = new QrCode($str);
        $qrCode->setSize(300);
        $qrCode->setMargin(10); 
        
        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        // $qrCode->setLabel('Scan the code', 16, __DIR__.'/../assets/fonts/noto_sans.otf', LabelAlignment::CENTER());
        // $qrCode->setLogoPath(__DIR__.'/../assets/images/symfony.png');
        // $qrCode->setLogoSize(150, 200);
        // $qrCode->setValidateResult(false);
        
        // Round block sizes to improve readability and make the blocks sharper in pixel based outputs (like png).
        // There are three approaches:
        // $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        // $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        // $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary
        
        // Set additional writer options (SvgWriter example)
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);
        
        // Directly output the QR code
        // header('Content-Type: '.$qrCode->getContentType());
        // echo $qrCode->writeString();
        
        // Save it to a file
        
        $qrImgUrl = 'uploads/qrimgs/'.'qrt'.md5($str).'.png';
        $file_dir = public_path($qrImgUrl);

        $qrCode->writeFile($file_dir);
        
        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $qrCode->writeDataUri();

        return $qrImgUrl;
    }

    public function getMenuAll(Request $request)
    {
        $restaurant_id = $request->id;
        $restName = Restaurant::find($restaurant_id)->restName;
        $menus = Restaurant::find($restaurant_id)->menus()->orderBy('foodName')->get();

        $record = array();
        $res['data'] = [];

        foreach ($menus as $menu) {
            $record['id'] = $menu->id;
            // $record['restName'] = $restName;
            $record['foodName'] = $menu->foodName;
            $record['foodPrice'] = $menu->foodPrice;
            $record['foodDescription'] = $menu->foodDescription;
            $record['foodPicUrl'] = $menu->foodPicUrl;
            $record['foodAvailable'] = $menu->foodAvailable;

            $res['data'][] = $record;
        }
        
        $res['recordsTotal'] = count($menus);
        $res['recordsFiltered'] = count($menus);

        return response()->json($res, 200);
    }

    public function menuSubmit(Request $request)
    { 
        $res = [];
        $res['status'] = 0;
        $res['msg'] = "";

        $request->validate([
            "foodName" => "required",
            'foodPrice' => "required|numeric",
            'foodAvailable' => "required",
            // 'foodPicUrl' => 'mimes:jpeg,png,jpg'
        ]);

        $picUrl = '';
        if ($request->hasFile('foodPicUrl')) {
            $file = $request->file('foodPicUrl');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $picture = $time . '-' . $filename;
            $picture = md5($picture).'.'.$extension;

            $file->move(public_path('uploads/menus'), $picture);
            $picUrl = 'uploads/menus/'.$picture;
        }

        if ($request->menu_id) {     // update
            $menu = Menu::find($request->menu_id);
        } else {                // insert
            $menu = new Menu;
        }

        // try {
            
        // } catch (\Throwable $th) {
        //     $res['status'] = 0;
        //     $res['msg'] = "Validation failed! User with same name exists!";

        //     return response()->json($res, 200);
        // }
        
        $menu->foodName        = $request->foodName;
        $menu->foodPrice       = $request->foodPrice;
        $menu->foodAvailable   = $request->foodAvailable;
        $menu->foodDescription = $request->foodDescription;
        $menu->restaurant_id   = $request->id;
        if($picUrl) $menu->foodPicUrl      = $picUrl;
        // $menu->contact     = $request->contact;

        $menu->save();
        // try {
        //     $staff->save();
        // } catch (\Throwable $th) {
        //     $res['status'] = 0;
        //     $res['msg'] = "Validation failed! User with same name exists!";

        //     return response()->json($res, 200);
        // }

        $res['status'] = 1;
        $res['msg'] = "success";

        return response()->json($res, 200);
    }

    public function getMenuOne(Request $request)
    {
        
        $res = [];
        $res['status'] = 0;

        if ($request->menu_id) {
            $menu = Menu::find($request->menu_id);
            
            if ($menu) {
                $res['status'] = 1;
                $res['data'] = $menu;
            }
        } else {
            $res['status'] = 1;
            $res['msg'] = "Failed";
        }
        
        return response()->json($res, 200);
    }

    public function deleteMenu(Request $request)
    {
        $staff = Menu::find($request->menu_id);
        $staff->delete();

        $res['status'] = 1;
        $res['msg'] = "success";

        return response()->json($res, 200);
    }
}
