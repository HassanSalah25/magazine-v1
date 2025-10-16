<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantCoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create core tables for tenant
        $this->createUsersTable();
        $this->createLanguagesTable();
        $this->createBasicSettingsTable();
        $this->createMenusTable();
        $this->createPagesTable();
        $this->createServicesTable();
        $this->createProductsTable();
        $this->createBlogsTable();
        $this->createFaqsTable();
        $this->createTestimonialsTable();
        $this->createGalleriesTable();
        $this->createSlidersTable();
        $this->createPartnersTable();
        $this->createSocialsTable();
        $this->createStatisticsTable();
        $this->createSubscribersTable();
        $this->createFeedbacksTable();
        $this->createTicketsTable();
        $this->createCoursesTable();
        $this->createPackagesTable();
        $this->createOrdersTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop tables in reverse order
        Schema::dropIfExists('orders');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('statistics');
        Schema::dropIfExists('socials');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('products');
        Schema::dropIfExists('services');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('basic_settings');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('users');
    }

    protected function createUsersTable()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('tenant_id');
            $table->string('domain');
            $table->boolean('is_tenant_owner')->default(false);
            $table->tinyInteger('status')->default(1);
            $table->string('email_verified')->default('no');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    protected function createLanguagesTable()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('direction')->default('ltr');
            $table->tinyInteger('is_default')->default(0);
            $table->timestamps();
        });
    }

    protected function createBasicSettingsTable()
    {
        Schema::create('basic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('site_name');
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->text('site_description')->nullable();
            $table->text('site_keywords')->nullable();
            $table->string('site_email');
            $table->string('site_phone')->nullable();
            $table->text('site_address')->nullable();
            $table->timestamps();
        });
    }

    protected function createMenusTable()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('name');
            $table->string('url');
            $table->integer('order');
            $table->timestamps();
        });
    }

    protected function createPagesTable()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createServicesTable()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createProductsTable()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createBlogsTable()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createFaqsTable()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('question');
            $table->text('answer');
            $table->integer('serial_number')->default(0);
            $table->unsignedBigInteger('service_id')->nullable();
            $table->timestamps();
            
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    protected function createTestimonialsTable()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('name');
            $table->string('designation');
            $table->text('comment');
            $table->string('image')->nullable();
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createGalleriesTable()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('image');
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createSlidersTable()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createPartnersTable()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('name');
            $table->string('image');
            $table->string('url')->nullable();
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createSocialsTable()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('icon');
            $table->string('url');
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createStatisticsTable()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('quantity');
            $table->string('icon')->nullable();
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createSubscribersTable()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    protected function createFeedbacksTable()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    protected function createTicketsTable()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    protected function createCoursesTable()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createPackagesTable()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    protected function createOrdersTable()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
};