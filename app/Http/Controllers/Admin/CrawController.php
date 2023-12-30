<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Product_Weight;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WeighTag;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Faker\Generator as Faker;

class CrawController extends Controller
{
    public function initial(): void
    {
        $idDefault = "maruDr-yfRui-tspRo-jectfORFOU-Rmembe";
        User::insert([
            "id" => $idDefault,
            'full_name' => "Superadmin",
            'email' => "administrator" . '@gmail.com',
            'password' => Hash::make('administrator'),
            'address' => ' 35/6 Đường D5, Phường 25, Bình Thạnh, Thành phố Hồ Chí Minh 72308',
            'phone' => '1800 1779',
            'level' => '1',
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);



        Category::insert([[
            'name' => "Nuts",
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => "Dried Fruits",
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => "Mixes",
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);

        WeighTag::insert([[
            'mass' => 250,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'mass' => 500,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'mass' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'mass' => 2000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
        Supplier::insert([
            [
                'name' => "JSON Dry Tree Supply Company",
                'email' => "jsondrytree" . '@gmail.com',
                'address' => '35/6 Đường D5, Phường 25, Bình Thạnh, Thành phố Hồ Chí Minh 72308',
                'phone' => '1800 1779',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => " Factory Supplying Aptech Dried Mussels",
                'email' => "aptechdriedmussels" . '@gmail.com',
                'address' => '778/10 Nguyễn Kiệm, Phường 3, Phú Nhuận, Thành phố Hồ Chí Minh 700990',
                'phone' => '1800 282824',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        $this->craw();
    }



    public function craw()
    {
        $context = stream_context_create(
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36"
                )
            )
        );

        $products = [];
        $count = 0;


        $nutsAndSeed = file_get_html("https://gardenpicks.com.sg/product-category/nuts-and-seeds/page/1/", false, $context);
        foreach ($nutsAndSeed->find('.status-publish') as $key => $value) {
            try {
                if ($key == 8) {
                    break;
                }
                // craw data
                $name = $value->find(".woocommerce-loop-product__title")[0]->innertext;
                $imageURL = $value->find(".woocommerce-LoopProduct-link img")[0]->attr["src"];
                $linkDetails = $value->find(".woocommerce-LoopProduct-link")[0]->attr["href"];
                $productDetails = file_get_html($linkDetails, false, $context);
                $products[$count]['name'] = $name;
                $products[$count]['description'] = $productDetails->find(".woocommerce-product-details__short-description")[0]->innertext;
                $products[$count]['nutrition_detail'] = $productDetails->find(".panel-body")[0]->innertext;
                $products[$count]['file_name_image'] = $this->slugify($name) . ".jpg";
                $products[$count]['price'] = rand(10, 40) / 10;
                $products[$count]['category_Id'] = 1;
                // $this->download_file($imageURL, public_path('/uploads/' . $products[$count]['file_name_image']));
                $count++;
            } catch (\Exception $e) {
                echo "Errors get data </br>";
                echo $e->getMessage();
                echo "</br>";
                continue;
            }
        }

        sleep(5);



        $nutsAndSeed = file_get_html("https://gardenpicks.com.sg/product-category/dried-fruits/", false, $context);
        foreach ($nutsAndSeed->find('.status-publish') as $key => $value) {
            try {
                // craw data
                if ($key == 8) {
                    break;
                }
                $name = $value->find(".woocommerce-loop-product__title")[0]->innertext;
                $imageURL = $value->find(".woocommerce-LoopProduct-link img")[0]->attr["src"];
                $linkDetails = $value->find(".woocommerce-LoopProduct-link")[0]->attr["href"];
                $productDetails = file_get_html($linkDetails, false, $context);
                $products[$count]['name'] = $name;
                $products[$count]['description'] = $productDetails->find(".woocommerce-product-details__short-description")[0]->innertext;
                $products[$count]['nutrition_detail'] = $productDetails->find(".panel-body")[0]->innertext;
                $products[$count]['file_name_image'] = $this->slugify($name) . ".jpg";
                $products[$count]['price'] = rand(10, 40) / 10;
                $products[$count]['category_Id'] = 2;
                // $this->download_file($imageURL, public_path('/uploads/' . $products[$count]['file_name_image']));
                $count++;
            } catch (\Exception $e) {
                echo "Errors get data </br>";
                echo $e->getMessage();
                echo "</br>";
                continue;
            }
        }
        sleep(5);

        $nutsAndSeed = file_get_html("https://gardenpicks.com.sg/product-category/mixes/", false, $context);
        foreach ($nutsAndSeed->find('.status-publish') as $key => $value) {
            try { // craw data

                $name = $value->find(".woocommerce-loop-product__title")[0]->innertext;
                $imageURL = $value->find(".woocommerce-LoopProduct-link img")[0]->attr["src"];
                $linkDetails = $value->find(".woocommerce-LoopProduct-link")[0]->attr["href"];
                $productDetails = file_get_html($linkDetails, false, $context);
                $products[$count]['name'] = $name;
                $products[$count]['description'] = $productDetails->find(".woocommerce-product-details__short-description")[0]->innertext;
                $products[$count]['nutrition_detail'] = $productDetails->find(".panel-body")[0]->innertext;
                $products[$count]['file_name_image'] = $this->slugify($name) . ".jpg";
                $products[$count]['price'] = rand(10, 40) / 10;
                $products[$count]['category_Id'] = 3;
                // $this->download_file($imageURL, public_path('/uploads/' . $products[$count]['file_name_image']));
                $count++;
            } catch (\Exception $e) {
                echo "Errors get data </br>";
                echo $e->getMessage();
                echo "</br>";
                continue;
            }
        }
        sleep(5);

        foreach ($products as $k => $v) {
            try {
                // insert data
                $product = new Product();
                $product->name = $products[$k]["name"];

                $file_path = public_path('/uploads/') . $products[$k]['file_name_image'];
                $uploadedFileUrl = Cloudinary::upload($file_path, [
                    "folder" => 'dry_fruits_image'
                ])->getSecurePath();
                $product->image = $uploadedFileUrl;

                $product->price = $products[$k]['price'];
                $product->status = 1;
                $product->feature = rand(1, 2);
                $product->sumary = 'If you need to buy wholesale, Please call office at 1800 1779 or email us at marudryfruits@gmail.com  to enquire ';
                $product->description = $products[$k]["description"];
                $product->nutrition_detail = $products[$k]["nutrition_detail"];
                $product->category_id = $products[$k]['category_Id'];
                $product->created_at = Carbon::now();
                $product->updated_at = Carbon::now();
                $product->save();

                $qrCodeImage = QrCode::size(100)->generate('http://localhost:8000/admin/product/detail/' . $product->id . '?scan=' . $product->id);
                $qrCodeData = 'data:image/svg+xml;base64,' . base64_encode($qrCodeImage);
                $uploadedQRUrl = Cloudinary::upload($qrCodeData, [
                    "folder" => 'dry_fruits_qrcode'
                ])->getSecurePath();

                $qrFilename = rand(1, 10000) . time() . "." . $product->id . '.svg';
                // file_put_contents(public_path("qrcode/{$qrFilename}"), $qrCodeImage);
                $product->qrcode = $uploadedQRUrl;
                $product->save();
                //insert in table Product_Weight
                $weights = WeighTag::get();

                $insert = [];
                foreach ($weights as $weight) {
                    $insert[] = [
                        "product_id" => $product->id, "weight_tag_id" => $weight->id, 'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                Product_Weight::insert($insert);
            } catch (\Exception $e) {
                echo "Errors insert </br>";
                echo $e->getMessage();
                echo "</br>";
            }
        }

        echo "Craw success";
    }

    public function warehouse()
    {
        $import = [];
        for ($i = 1; $i <= 23; $i++) {
            $import = [
                'product_id' => $i,
                'supplier_id' => rand(1, 2),
                'input_price' => rand(10, 30) / 10,
                'transaction_type' => 1,
                'quantity' => 200,
                'current_quantity' => 200,
                'expiration_date' => '2023-12-31',
                'transaction_date' => now(),
                'shipment' => rand(1000, 99999) . Carbon::now()->timestamp,
                'created_at' => now(),
                'updated_at' => now()
            ];
            Warehouse::insert($import);

            $export = [
                'product_id' => $i,
                'supplier_id' => $import['supplier_id'],
                'input_price' => $import['input_price'],
                'transaction_type' => 2,
                'quantity' => 20,
                'current_quantity' => $import['quantity'] - 20,
                'expiration_date' => $import['expiration_date'],
                'transaction_date' => $import['transaction_date'],
                'shipment' => $import['shipment'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            Warehouse::insert($export);
            $importStore = Warehouse::where([['product_id', $import['product_id']], ['transaction_type', 1]])->first();
            $importStore->current_quantity = $export['current_quantity'];
            $importStore->update();
        }
    }


    public function user(Faker $faker)
    {
        for ($i = 1; $i <= 100; $i++) {
            $user = new User();
            $user->id = $i;
            $user->full_name = $faker->name;
            $user->email = $faker->unique()->email;
            $user->password = Hash::make('12345678');
            $user->phone = '1234567';
            $user->address = $faker->address;
            $user->level = 2;
            $user->status = 1;
            $user->save();
        }
    }

    public function order(Faker $faker)
    {
        $users = User::inRandomOrder()->take(5)->get();
        // dd($users);
        foreach ($users as $user) {
            $order = new Order();
            $order->user_id = $user->id;
            $order->status = 1;
            $order->discount = 0;
            $order->transaction = 1;
            $order->transaction_status = 2;
            $order->email = $user->email;
            $order->full_name = $user->full_name;
            $order->address = $user->address;
            $order->phone = $faker->phoneNumber;
            $order->subtotal = 0;
            $order->total = 0;
            $order->save();

            $order_items = [];
            for ($k = 1; $k <= 3; $k++) {

                $order_items[$k]['product_id'] = rand(1, 20);
                $order_items[$k]['order_id'] = $order->id;
                $order_items[$k]['quantity'] = rand(1, 4);
                $order_items[$k]['weight'] = 250;
                $product = Product::findOrFail($order_items[$k]['product_id']);
                $order_items[$k]['price'] = $product->price * ($order_items[$k]['weight'] / 100 * $order_items[$k]['quantity']);
            }
            OrderItems::insert($order_items);

            $orderItems = OrderItems::where("order_id", $order->id)->get();

            foreach ($orderItems as $item) {
                $order->subtotal += $item->price;
            }
            $order->total = $order->subtotal + ($order->subtotal * $order->discount / 100);
            $order->save();
        }
    }
    public function formatPrice($data)
    {
        $price = str_replace("<!-- --> - <!-- -->", " ", $data);
        $price = str_replace("\u{A0}₫", "", $price);
        $price = str_replace(".", "", $price);
        return $price;
    }
    public function slugify($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        $str = preg_replace('/-+/', '-', $str);

        $str = str_replace('***10kg wholesale bag available. Kindly call office at 66594859 or email us at enquiries@gardenpicks.com.sg to enquire', 'If you need to buy wholesale, Please call office at 1800 1779 or email us at marudryfruits@gmail.com  to enquire ', $str);


        return $str;
    }

    public function download_file($file_url, $file_name)
    {
        // $time_start = microtime(true);
        file_put_contents($file_name, file_get_contents($file_url));
        // $this->count++;
        // $time_end = microtime(true);
        // $total_time = $time_end - $time_start;
        // echo $this->count, "------>", $total_time, "<br/>";
    }
}
