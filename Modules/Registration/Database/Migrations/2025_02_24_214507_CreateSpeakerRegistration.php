<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeakerRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speaker_registration', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guest_code', 150)->nullable();
            $table->string('topic', 300);
            //lĩnh vực báo cáo: report_
            $table->string('session', 200)->nullable();
            $table->enum('report_lang', ['vi', 'en'])->nullable();
            //             Thời hạn nộp báo cáo:
            // + Thời gian nộp bài báo cáo tóm tắt (tiếng Việt và tiếng Anh): trước ngày 
            $table->date('report_deadline_summary')->nullable();
            // + Thời gian nộp bài toàn văn: trước ngày      
            $table->date('report_deadline_full')->nullable();
            // file báo cáo tóm tắt
            $table->string('report_file_summary', 350)->nullable();
            $table->string('report_file_full', 350)->nullable();
            $table->string('shortCV', 350)->nullable();
            $table->string('passport', 350)->nullable();
            //ĐĂNG KÝ ĐĂNG BÀI TRÊN TẠP CHÍ NGOẠI KHOA VÀ PHẪU THUẬT NỘI SOI VIỆT NAM *
            $table->enum('journal_vn', ['yes', 'no'])->nullable();
            $table->string('title', 300);
            $table->string('fullname', 250);
            $table->string('work', 300);
            $table->string('organization', 350);
            $table->string('address', 350);
            $table->string('email', 150);
            $table->string('phone', 50);
            $table->string('cid', 120)->nullable();
            $table->enum('gender', ['nam', 'nữ'])->nullable();
            // ngày sinh
            $table->integer('birthday')->nullable();
            // tháng sinh
            $table->integer('birthmonth')->nullable();
            // năm sinh
            $table->integer('birthyear')->nullable();
            //ĐĂNG KÝ THAM DỰ TẬP HUẤN TIỀN HỘI NGHỊ 
            $table->enum('training', ['yes', 'no'])->nullable();
            //chuyên khoa
            $table->string('course', 300)->nullable();
            // số năm kinh nghiệm
            $table->integer('experience')->nullable();
            // đăng ký khóa
            $table->string('course_name', 300)->nullable();
            //ĐĂNG KÝ THAM DỰ TIỆC CHIÊU ĐÃI HỘI NGHỊ
            $table->enum('galadinner', ['yes', 'no'])->nullable();
            // hình thức nhận giấy mời
            $table->enum('form_invitation', ['soft', 'hard'])->nullable();
            // hình thức nhận giấy chứng nhận
            $table->enum('form_certificate', ['soft', 'hard'])->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speaker_registration');
    }
}
