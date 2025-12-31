<?php

namespace App\Traits;

trait BilingualValidation
{
    public function messages(): array
    {
        return $this->getBilingualMessages();
    }

    protected function getBilingualMessages(): array
    {
        $messages = [];
        $bilingualMessages = $this->bilingualMessages();

        foreach ($bilingualMessages as $key => $translations) {
            $messages[$key] = [
                'ar' => $translations['ar'],
                'en' => $translations['en']
            ];
        }

        return $messages;
    }

    protected function bilingualMessages(): array
    {
        return [];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = [];
        
        foreach ($validator->errors()->messages() as $field => $messages) {
            $errors[$field] = [];
            foreach ($messages as $message) {
                if (is_array($message)) {
                    $errors[$field][] = $message;
                } else {
                    // If it's a string, try to find bilingual version
                    $bilingualMessages = $this->bilingualMessages();
                    $found = false;
                    
                    foreach ($bilingualMessages as $key => $translations) {
                        if (str_contains($key, $field)) {
                            $errors[$field][] = [
                                'ar' => $translations['ar'],
                                'en' => $translations['en']
                            ];
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $errors[$field][] = [
                            'ar' => $message,
                            'en' => $message
                        ];
                    }
                }
            }
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'success' => false,
                'message' => [
                    'ar' => 'يوجد أخطاء في البيانات المدخلة',
                    'en' => 'Validation errors occurred'
                ],
                'errors' => $errors
            ], 422)
        );
    }
}