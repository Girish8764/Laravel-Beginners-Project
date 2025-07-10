@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Custom Admit Card Designer</h4>
      <a href="{{ route('admin.admit-card.index') }}" class="btn btn-secondary btn-sm">
        <i class="mdi mdi-arrow-left"></i> Back
      </a>
    </div>

    <div class="alert alert-info">
      Drag and place elements to design the admit card. Click "Download" to save. Use the toolbar below to add text, shapes, or images.
    </div>

    <div class="mb-3">
      <button onclick="addText()" class="btn btn-outline-primary btn-sm me-2"><i class="mdi mdi-format-text"></i> Add Text</button>
      <button onclick="addLine()" class="btn btn-outline-info btn-sm me-2"><i class="mdi mdi-minus"></i> Add Line</button>
      <button onclick="addRect()" class="btn btn-outline-warning btn-sm me-2"><i class="mdi mdi-checkbox-blank-outline"></i> Add Box</button>
      <button onclick="addCircle()" class="btn btn-outline-success btn-sm me-2"><i class="mdi mdi-circle-outline"></i> Add Circle</button>
      <button onclick="triggerImageUpload()" class="btn btn-outline-dark btn-sm me-2"><i class="mdi mdi-image-plus"></i> Add Image</button>
      <button onclick="deleteSelected()" class="btn btn-outline-danger btn-sm me-2"><i class="mdi mdi-delete"></i> Delete Selected</button>
      <input type="file" id="imgInput" accept="image/*" hidden />
    </div>

    <canvas id="admitCanvas" width="1000" height="600" style="border:2px dashed #999;"></canvas>

    <div class="mt-4 text-end">
      <button onclick="downloadAdmitCard()" class="btn btn-success">
        <i class="mdi mdi-download"></i> Download Admit Card
      </button>
    </div>
  </div>
</div>
</div>
@include('admin.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const canvas = new fabric.Canvas('admitCanvas');
    canvas.setBackgroundColor('#fff', canvas.renderAll.bind(canvas));

    // Example dummy fallback (for demo purpose)
    const student = window.student ?? { name: "John Doe", father_name: "Mr. Smith", admission_class: "10", stream: "Science" };
    const exams = window.exams ?? [];
    const school = window.school ?? { school_name: "My School" };

    canvas.add(new fabric.Text(school.school_name ?? 'School Name', {
      left: 400,
      top: 20,
      fontSize: 22,
      fontWeight: 'bold'
    }));

    canvas.add(new fabric.Text('Name: ' + student.name, {
      left: 40,
      top: 100,
      fontSize: 18
    }));

    canvas.add(new fabric.Text('Father: ' + student.father_name, {
      left: 40,
      top: 130,
      fontSize: 18
    }));

    canvas.add(new fabric.Text('Class: ' + student.admission_class + ', Stream: ' + student.stream, {
      left: 40,
      top: 160,
      fontSize: 18
    }));

    let top = 200;
    exams.forEach((exam, i) => {
      canvas.add(new fabric.Text(`${i + 1}. ${exam.subject} | ${exam.exam_date} | ${exam.start_time}-${exam.end_time} (${exam.shift})`, {
        left: 50,
        top: top,
        fontSize: 15
      }));
      top += 25;
    });

    canvas.add(new fabric.Text('Principal Signature', {
      left: 750,
      top: 520,
      fontSize: 16
    }));

    window.addText = function () {
      const text = new fabric.IText('Enter text here', {
        left: 100,
        top: 100,
        fontSize: 18,
        fill: 'black'
      });
      canvas.add(text).setActiveObject(text);
    }

    window.addLine = function () {
      const line = new fabric.Line([50, 100, 300, 100], {
        stroke: 'black',
        strokeWidth: 2
      });
      canvas.add(line).setActiveObject(line);
    }

    window.addRect = function () {
      const rect = new fabric.Rect({
        left: 150,
        top: 150,
        width: 100,
        height: 60,
        fill: 'transparent',
        stroke: 'black',
        strokeWidth: 2
      });
      canvas.add(rect).setActiveObject(rect);
    }

    window.addCircle = function () {
      const circle = new fabric.Circle({
        left: 200,
        top: 200,
        radius: 40,
        fill: 'transparent',
        stroke: 'black',
        strokeWidth: 2
      });
      canvas.add(circle).setActiveObject(circle);
    }

    window.deleteSelected = function () {
      const active = canvas.getActiveObject();
      if (active) canvas.remove(active);
    }

    window.triggerImageUpload = function () {
      document.getElementById('imgInput').click();
    }

    document.getElementById('imgInput').addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (f) {
        fabric.Image.fromURL(f.target.result, function (img) {
          img.set({ left: 100, top: 100, scaleX: 0.5, scaleY: 0.5 });
          canvas.add(img).setActiveObject(img);
        });
      };
      reader.readAsDataURL(file);
    });

    window.downloadAdmitCard = function () {
      const dataURL = canvas.toDataURL({ format: 'png', quality: 1 });
      const link = document.createElement('a');
      link.href = dataURL;
      link.download = 'Admit_Card_' + (student.name || 'student').replace(/\s/g, '_') + '.png';
      link.click();
    }
  });
</script>

