<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// مسارات المنشورات
Route::get('/posts', [PostController::class, 'index']); // عرض جميع المنشورات
Route::get('/posts/{id}', [PostController::class, 'show']); // عرض منشور واحد
Route::post('/posts', [PostController::class, 'store']); // إنشاء منشور
Route::put('/posts/{id}', [PostController::class, 'update']); // تعديل منشور
Route::delete('/posts/{id}', [PostController::class, 'destroy']); // حذف منشور

// مسارات الفئات
Route::post('/categories', [CategoryController::class, 'store']); // إنشاء فئة
Route::get('/categories', [CategoryController::class, 'index']); // عرض جميع الفئات
Route::get('/categories/{category}', [CategoryController::class, 'show']); // عرض فئة معينة
Route::put('/categories/{category}', [CategoryController::class, 'update']); // تحديث فئة معينة
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']); // حذف فئة معينة

// مسارات التعليقات
Route::post('/posts/{postId}/comments', [CommentController::class, 'store']); // إنشاء تعليق على منشور
Route::put('/comments/{id}', [CommentController::class, 'update']); // تعديل تعليق
Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // حذف تعليق

// مسارات المستخدمين
Route::post('/register', [UserController::class, 'register']); // إنشاء حساب
Route::get('/users/{id}', [UserController::class, 'show']); // عرض حساب المستخدم
Route::put('/users/{id}', [UserController::class, 'update']); // تعديل الحساب
Route::delete('/users/{id}', [UserController::class, 'destroy']); // حذف الحساب
Route::post('/logout', [UserController::class, 'logout']); // تسجيل الخروج
