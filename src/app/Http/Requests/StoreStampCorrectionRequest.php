<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStampCorrectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'requested_clock_in'  => ['nullable', 'date_format:H:i'],
            'requested_clock_out' => ['nullable', 'date_format:H:i'],

            'break_start' => ['nullable', 'date_format:H:i'],
            'break_end'   => ['nullable', 'date_format:H:i'],

            'reason' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // 4) 備考未入力
            'reason.required' => '備考を記入してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $in  = $this->input('requested_clock_in');
            $out = $this->input('requested_clock_out');
            $bs  = $this->input('break_start');
            $be  = $this->input('break_end');

            // 文字列 "H:i" を分単位に変換（nullならnull）
            $toMin = function (?string $t): ?int {
                if (!$t) return null;
                [$h, $m] = array_map('intval', explode(':', $t));
                return $h * 60 + $m;
            };

            $inM  = $toMin($in);
            $outM = $toMin($out);
            $bsM  = $toMin($bs);
            $beM  = $toMin($be);

            // 1) 出勤 > 退勤（両方入っているときだけチェック）
            if (!is_null($inM) && !is_null($outM) && $inM > $outM) {
                $validator->errors()->add('requested_clock_in', '出勤時間もしくは退勤時間が不適切な値です');
            }

            // 2) 休憩開始が 出勤より前 or 退勤より後
            // ※出勤/退勤が入力されている場合にのみ判定（未入力なら判定しない）
            if (!is_null($bsM)) {
                if (!is_null($inM) && $bsM < $inM) {
                    $validator->errors()->add('break_start', '休憩時間が不適切な値です');
                }
                if (!is_null($outM) && $bsM > $outM) {
                    $validator->errors()->add('break_start', '休憩時間が不適切な値です');
                }
            }

            // 3) 休憩終了が 退勤より後
            if (!is_null($beM) && !is_null($outM) && $beM > $outM) {
                $validator->errors()->add('break_end', '休憩時間もしくは退勤時間が不適切な値です');
            }
        });
    }
}
