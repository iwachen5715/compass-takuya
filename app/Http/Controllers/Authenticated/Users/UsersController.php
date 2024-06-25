<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Requests\StoreUserRequest;
use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    //  public function store(StoreUserRequest $request)
    // {

    //     // dd($request->all());
    //     $validatedData = $request->validated();

    //     // dd($validatedData);

    //     // 新しいユーザーの作成
    //     $user = User::create([
    //         'over_name' => $validatedData['over_name'],
    //         'under_name' => $validatedData['under_name'],
    //         'over_name_kana' => $validatedData['over_name_kana'],
    //         'under_name_kana' => $validatedData['under_name_kana'],
    //         'mail_address' => $validatedData['mail_address'],
    //         'sex' => $validatedData['sex'],
    //         'birth_day' => $validatedData['birth_day'],
    //         'role' => $validatedData['role'],
    //         'password' => bcrypt($validatedData['password']),
    //     ]);

    //     // ユーザー登録後の処理
    //     return response()->json($user, 201);
    // }

    public function showUsers(Request $request){
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = null;// ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }


}
