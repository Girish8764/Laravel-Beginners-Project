<!DOCTYPE html>
<html>
<head>
    <title>ID Card - Staff</title>
    <style>
        .id-card { width: 300px; height: 180px; border: 2px dashed #444; margin: 10px; float: left; padding: 10px; background: #fff7e6; }
        .photo { width: 70px; height: 80px; border: 1px solid #333; }
        .info { font-size: 12px; }
    </style>
</head>
<body>
@foreach($teachers as $staff)
<div class="id-card">
    <div style="text-align: center;">
        <img src="{{ asset('storage/' . $admin->logo) }}" style="height: 40px;"><br>
        <strong>{{ $admin->school_name }}</strong>
    </div>
    <div style="display: flex; margin-top: 5px;">
        <img src="{{ asset('storage/' . $staff->photo) }}" class="photo">
        <div class="info" style="margin-left: 10px;">
            <b>{{ $staff->name }}</b><br>
            ID: {{ $staff->staff_id }}<br>
            Designation: {{ $staff->designation }}
        </div>
    </div>
</div>
@endforeach
</body>
</html>
