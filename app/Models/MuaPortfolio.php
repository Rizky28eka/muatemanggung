<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuaPortfolio extends Model
{
    protected $fillable = ['mua_id', 'file_path', 'embed_url', 'file_type', 'caption', 'sort_order'];

    public function mua()
    {
        return $this->belongsTo(Mua::class);
    }

    public function getEmbedUrlAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Convert standard YouTube or Instagram URLs to safe iframe embed formats
        if (str_contains($value, 'youtube.com') || str_contains($value, 'youtu.be')) {
            $videoId = '';
            
            if (str_contains($value, 'youtu.be/')) {
                $parts = explode('youtu.be/', $value);
                $end = end($parts);
                $videoId = explode('?', $end)[0];
            } elseif (str_contains($value, 'youtube.com/shorts/')) {
                $parts = explode('youtube.com/shorts/', $value);
                $end = end($parts);
                $videoId = explode('?', $end)[0];
            } else {
                parse_str(parse_url($value, PHP_URL_QUERY) ?? '', $queryParams);
                if (isset($queryParams['v'])) {
                    $videoId = $queryParams['v'];
                } else {
                    $pathParts = explode('embed/', $value);
                    if (count($pathParts) > 1) {
                        $videoId = explode('?', $pathParts[1])[0];
                    }
                }
            }
            
            if ($videoId) {
                return "https://www.youtube.com/embed/" . trim($videoId);
            }
        }
        
        if (str_contains($value, 'instagram.com')) {
            if (str_contains($value, '/embed')) {
                return $value;
            }
            
            $url = rtrim($value, '/');
            $path = parse_url($url, PHP_URL_PATH) ?? '';
            $parts = array_values(array_filter(explode('/', $path)));
            
            $code = '';
            foreach ($parts as $index => $part) {
                if (($part === 'p' || $part === 'reel') && isset($parts[$index + 1])) {
                    $code = $parts[$index + 1];
                    break;
                }
            }
            
            if ($code) {
                return "https://www.instagram.com/p/" . trim($code) . "/embed";
            }
        }

        return $value;
    }

    public function getUrlAttribute(): string
    {
        if ($this->embed_url) {
            return $this->embed_url;
        }
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }
        return $this->file_path ? asset('storage/' . $this->file_path) : '';
    }

    public function isPhoto(): bool
    {
        return $this->file_type === 'photo';
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }
}
