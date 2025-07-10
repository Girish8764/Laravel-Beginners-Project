<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Cards Print</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
        }

        .print-container {
            width: 100%;
            padding: 20px;
        }

        .id-card {
            width: {{ $template->width }}px;
            height: {{ $template->height }}px;
            margin: 10px;
            display: inline-block;
            vertical-align: top;
            position: relative;
            background: #fff;
            page-break-inside: avoid;
            border: 1px solid #000;
        }

        .canvas-element {
            position: absolute;
        }

        .text-element {
            font-family: Arial, sans-serif;
            overflow: hidden;
            word-wrap: break-word;
        }

        .photo-placeholder {
            border: 2px dashed #bdc3c7;
            background: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #95a5a6;
            font-size: 12px;
            font-weight: bold;
        }

        .logo-placeholder {
            border: 2px dashed #3498db;
            background: #e3f2fd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1976d2;
            font-size: 12px;
            font-weight: bold;
        }

        .rectangle-element {
            box-sizing: border-box;
        }

        .line-element {
            position: absolute;
            transform-origin: top left;
        }

        /* Print styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .print-container {
                padding: 10px;
            }
            
            .id-card {
                margin: 5px;
                box-shadow: none;
            }
            
            .no-print {
                display: none;
            }
            
            @page {
                margin: 0.5in;
                size: A4;
            }
        }

        /* Responsive grid for different card orientations */
        @media screen and (max-width: 768px) {
            .id-card {
                width: 100% !important;
                max-width: 350px;
                margin: 10px auto;
                display: block;
            }
        }

        /* Custom styles from template */
        {!! $template->css_styles ?? '' !!}
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Print Controls -->
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Print ID Cards
            </button>
            <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                Close
            </button>
        </div>

        <!-- ID Cards -->
        @foreach($records as $record)
            <div class="id-card">
                @if(isset($template->template_data['elements']))
                    @foreach($template->template_data['elements'] as $element)
                        @if($element['type'] === 'text')
                            <div class="canvas-element text-element" style="
                                left: {{ $element['x'] }}px;
                                top: {{ $element['y'] }}px;
                                width: {{ $element['width'] }}px;
                                height: {{ $element['height'] }}px;
                                font-size: {{ $element['fontSize'] }}px;
                                font-family: {{ $element['fontFamily'] }};
                                color: {{ $element['color'] }};
                                text-align: {{ $element['align'] }};
                                font-weight: {{ $element['bold'] ? 'bold' : 'normal' }};
                                font-style: {{ $element['italic'] ? 'italic' : 'normal' }};
                                line-height: {{ $element['fontSize'] + 2 }}px;
                            ">
                                {{ parseTemplateText($element['text'], $record, $type) }}
                            </div>
                        @elseif($element['type'] === 'photo')
                            <div class="canvas-element photo-placeholder" style="
                                left: {{ $element['x'] }}px;
                                top: {{ $element['y'] }}px;
                                width: {{ $element['width'] }}px;
                                height: {{ $element['height'] }}px;
                            ">
                                PHOTO
                            </div>
                        @elseif($element['type'] === 'logo')
                            <div class="canvas-element logo-placeholder" style="
                                left: {{ $element['x'] }}px;
                                top: {{ $element['y'] }}px;
                                width: {{ $element['width'] }}px;
                                height: {{ $element['height'] }}px;
                            ">
                                LOGO
                            </div>
                        @elseif($element['type'] === 'rectangle')
                            <div class="canvas-element rectangle-element" style="
                                left: {{ $element['x'] }}px;
                                top: {{ $element['y'] }}px;
                                width: {{ $element['width'] }}px;
                                height: {{ $element['height'] }}px;
                                background-color: {{ $element['fillColor'] ?? 'transparent' }};
                                border: {{ $element['strokeWidth'] ?? 1 }}px solid {{ $element['strokeColor'] ?? '#000' }};
                            ">
                            </div>
                        @elseif($element['type'] === 'line')
                            @php
                                $length = sqrt(pow($element['x2'] - $element['x1'], 2) + pow($element['y2'] - $element['y1'], 2));
                                $angle = atan2($element['y2'] - $element['y1'], $element['x2'] - $element['x1']) * 180 / pi();
                            @endphp
                            <div class="canvas-element line-element" style="
                                left: {{ $element['x1'] }}px;
                                top: {{ $element['y1'] }}px;
                                width: {{ $length }}px;
                                height: {{ $element['strokeWidth'] ?? 1 }}px;
                                background-color: {{ $element['strokeColor'] ?? '#000' }};
                                transform: rotate({{ $angle }}deg);
                            ">
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>

    <script>
        Auto-print when page loads (optional)
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

@php
function parseTemplateText($text, $record, $type) {
    $fieldMappings = [];

    if ($type === 'student') {
        $fieldMappings = [
            '{name}' => $record->student_name ?? '',
            '{class}' => $record->admission_class ?? '',
            '{section}' => $record->section ?? '',
            '{roll_number}' => $record->rollno ?? '',
            '{father_name}' => $record->father_name ?? '',
            '{mobile}' => $record->mobile ?? '',
            '{admission_no}' => $record->admission_no ?? '',
            '{session}' => $record->session ?? '',
            '{dob}' => $record->dob ?? '',
            '{address}' => $record->address ?? '',
        ];
    } elseif ($type === 'staff') {
        $fieldMappings = [
            '{name}' => $record->name ?? '',
            '{subject}' => $record->subject ?? '',
            '{email}' => $record->email ?? '',
            '{mobile}' => $record->mobile ?? '',
            '{joining_date}' => $record->joining_date ?? '',
            '{employee_id}' => $record->employee_id ?? '',
            '{department}' => $record->department ?? '',
            '{designation}' => $record->designation ?? '',
        ];
    }

    foreach ($fieldMappings as $placeholder => $value) {
        $text = str_replace($placeholder, $value, $text);
    }

    return $text;
}
@endphp
