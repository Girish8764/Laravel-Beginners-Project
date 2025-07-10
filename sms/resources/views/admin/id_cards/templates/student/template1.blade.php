<!DOCTYPE html>
<html>
<head>
    <title>Student ID Cards</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f3f7;
            padding: 20px;
        }

        .id-card {
            width: 340px;
            height: 220px;
            background: linear-gradient(to bottom, #ffffff 0%, #e3f2fd 100%);
            border: 2px solid #1976d2;
            border-radius: 10px;
            margin: 15px;
            float: left;
            padding: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }

        .header img {
            width: 48px;
            height: auto;
        }

        .header h4 {
            margin: 5px 0;
            color: #0d47a1;
            font-size: 18px;
        }

        .header p {
            font-size: 10px;
            color: #424242;
        }

        .body {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .photo {
            width: 80px;
            height: 100px;
            border-radius: 4px;
            border: 2px solid #0d47a1;
            object-fit: cover;
        }

        .info {
            font-size: 13px;
            color: #212121;
        }

        .info strong {
            font-size: 14px;
            color: #0d47a1;
        }

        .footer {
            margin-top: 8px;
            font-size: 10px;
            text-align: right;
            color: #757575;
        }
    </style>
</head>
<body>

@foreach($students as $student)
<div class="id-card">
    <div class="header">
        <img src="{{ $admin->logo ? asset($admin->logo) : asset('uploads/admin/1750680549.png') }}" alt="School Logo">
        <h4>{{ $admin->school_name }}</h4>
        <p>{{ $admin->address }}</p>
    </div>
    <div class="body">
        <img src="{{ $student->img ? asset('storage/' . $student->img) : asset('uploads/admin/1750680549.png') }}" class="photo" alt="Student Photo">
        <div class="info">
            <strong>{{ $student->student_name }}</strong><br>
            Class: {{ $student->admission_class }}<br>
            Admission No: {{ $student->sr_no }}<br>
        </div>
    </div>
    <div class="footer">
        ID Valid for Academic Year {{ date('Y') }}-{{ date('Y')+1 }}
    </div>
</div>
@endforeach

</body>
</html>
