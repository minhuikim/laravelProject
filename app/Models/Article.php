<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // 대량할당 에러 해결을 위해 fillable 속성 추가
    // 접근 가능 (채워넣을 수 있는) - 화이트리스트
    protected $fillable = ['body', 'user_id'];

    // 보호 (id 제외 나머지 허용) - 블랙리스트
    // protected $guarded = ['id'];
}
