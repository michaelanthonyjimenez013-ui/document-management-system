<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateFileUpload
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasFile('file') || $request->hasFile('files')) {
            $files = $request->hasFile('files') ? $request->file('files') : [$request->file('file')];
            
            $allowedMimes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/jpg',
                'image/png',
            ];
            
            $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $maxFileSize = 10 * 1024 * 1024; // 10MB
            
            foreach ($files as $file) {
                // Check file extension
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedExtensions)) {
                    return back()->with('error', "Invalid file type: {$extension}. Allowed types: PDF, DOC, DOCX, JPG, PNG.");
                }
                
                // Check MIME type
                $mimeType = $file->getMimeType();
                if (!in_array($mimeType, $allowedMimes)) {
                    return back()->with('error', "Invalid MIME type: {$mimeType}");
                }
                
                // Check file size
                if ($file->getSize() > $maxFileSize) {
                    return back()->with('error', "File too large. Maximum size is 10MB.");
                }
                
                // Check for malicious file signatures
                $fileContent = file_get_contents($file->getPathname());
                if ($this->containsMaliciousContent($fileContent)) {
                    return back()->with('error', "File contains potentially malicious content.");
                }
            }
        }
        
        return $next($request);
    }
    
    /**
     * Check for potentially malicious content in file
     */
    private function containsMaliciousContent($content): bool
    {
        // Check for PHP tags
        if (preg_match('/<\?php/i', $content)) {
            return true;
        }
        
        // Check for script tags
        if (preg_match('/<script/i', $content)) {
            return true;
        }
        
        // Check for executable patterns
        $dangerousPatterns = [
            '/eval\s*\(/i',
            '/exec\s*\(/i',
            '/system\s*\(/i',
            '/passthru\s*\(/i',
            '/shell_exec\s*\(/i',
        ];
        
        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }
        
        return false;
    }
}
