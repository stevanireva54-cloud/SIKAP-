<?php
namespace App\Services;

use App\Models\Signature;

class DocumentSnapshot
{
    public static function capture(array $input): array
    {
        unset($input['_token'], $input['_method'], $input['password'], $input['password_confirmation']);
        $resolve = function (array $row) use (&$resolve): array {
            foreach ($row as $key => $value) {
                if (is_array($value)) {
                    $row[$key] = $resolve($value);
                } elseif (str_ends_with((string) $key, 'signature_id')) {
                    $signature = $value ? Signature::find($value) : null;
                    $nameKey = $key === 'signature_id' ? 'signature_name' : substr($key, 0, -3) . '_name';
                    $row[$nameKey] = $signature?->name ?? '';
                }
            }
            return $row;
        };
        return $resolve($input);
    }
}
