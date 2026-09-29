<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. CÁC BẢNG ĐỘC LẬP (Không chứa khóa ngoại)
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('google_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('birthday')->nullable();
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->enum('status', ['dang_hoat_dong', 'dung_hoat_dong']);
            $table->timestamps();
        });

        Schema::create('attr_tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('link')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('content');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('link')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('_lft')->nullable();
            $table->integer('_rgt')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();

            // Khóa ngoại đệ quy
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percent', 'fixed']);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->decimal('min_order_value', 10, 2)->nullable();
            $table->string('event_type')->default('normal');
            $table->integer('quantity')->default(0);
            $table->integer('used_count')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('status')->default(1); // tinyint(1)
            $table->timestamps();
        });

        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_orders')->default(0);
            $table->bigInteger('total_revenue')->default(0);
            $table->integer('total_users')->default(0);
            $table->bigInteger('total_views')->default(0);
            $table->timestamps();
        });

        // 2. CÁC BẢNG CẤP 1 (Phụ thuộc vào 1 bảng khác)

        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('time')->nullable();
            $table->bigInteger('price')->default(0);
            $table->bigInteger('sale_price')->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('start_location')->nullable();
            $table->string('end_location')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('category_id');
            $table->integer('quantity')->default(1);
            $table->date('start_date')->nullable();
            $table->longText('embedding')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->string('subject');
            $table->text('body');
            $table->enum('status', ['sent', 'failed']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['booking', 'payment', 'system', 'chat']);
            $table->enum('status', ['unread', 'read'])->default('unread');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('user_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('voucher_id');
            $table->boolean('status')->default(0); // tinyint(1)
            $table->dateTime('used_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
        });

        // 3. CÁC BẢNG CẤP 2

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tour_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('image_tours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('tour_id')->references('id')->on('tours')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('tour_attr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('attr_tour_id');
            $table->timestamps();

            $table->foreign('tour_id')->references('id')->on('tours')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('attr_tour_id')->references('id')->on('attr_tours')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('tour_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->integer('day_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location_name')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('map_link', 500)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('tour_id')->references('id')->on('tours')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('view')->default(0);
            $table->unsignedBigInteger('tour_id')->nullable();
            $table->timestamps();

            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->string('sender_type', 20);
            $table->text('message');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('chat_sessions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('phone', 20);
            $table->string('email');
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('total_price')->default(0);
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('time')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('tour_id')->references('id')->on('tours')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
        });

        // 4. CÁC BẢNG CẤP 3 & 4

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount', 10, 2);
            $table->string('payment_type', 50);
            $table->string('payment_method', 50);
            $table->string('charge_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->text('reply')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->enum('transaction_type', ['init', 'confirm', 'refund', 'error']);
            $table->decimal('amount', 10, 2);
            $table->string('transaction_code')->nullable();
            $table->json('response_data')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tắt kiểm tra khóa ngoại trước khi drop để tránh lỗi
        Schema::disableForeignKeyConstraints();

        $tables = [
            'transactions', 'reviews', 'payments', 'orders', 'chat_messages', 
            'views', 'tour_schedules', 'tour_attr', 'image_tours', 'favorites', 
            'user_vouchers', 'notifications', 'email_logs', 'chat_sessions', 
            'tours', 'statistics', 'vouchers', 'categories', 'blogs', 'banners', 
            'attr_tours', 'users'
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }
};
