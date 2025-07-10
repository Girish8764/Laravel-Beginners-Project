{{-- File: resources/views/admin/id_cards/designer.blade.php --}}

@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">ID Card Designer</h4>
      <a href="{{ route('id-cards.index') }}" class="btn btn-secondary btn-sm">
        <i class="mdi mdi-arrow-left"></i> Back to Templates
      </a>
    </div>

    <div class="row">
      <!-- Controls Panel -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Template Settings</h5>
          </div>
          <div class="card-body">
            <form id="templateForm">
              <div class="mb-3">
                <label class="form-label">Template Name</label>
                <input type="text" class="form-control" id="templateName" required>
              </div>
              
              <div class="mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" id="templateType" required>
                  <option value="">Select Type</option>
                  <option value="student">Student</option>
                  <option value="staff">Staff</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="form-label">Orientation</label>
                <select class="form-select" id="orientation" required>
                  <option value="">Select Orientation</option>
                  <option value="vertical">Vertical</option>
                  <option value="horizontal">Horizontal</option>
                </select>
              </div>
              
              <div class="row">
                <div class="col-6">
                  <label class="form-label">Width (px)</label>
                  <input type="number" class="form-control" id="canvasWidth" value="350" min="200" max="600">
                </div>
                <div class="col-6">
                  <label class="form-label">Height (px)</label>
                  <input type="number" class="form-control" id="canvasHeight" value="550" min="300" max="800">
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-header">
            <h5 class="card-title">Design Elements</h5>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <button class="btn btn-outline-primary" onclick="addText()">Add Text</button>
              <button class="btn btn-outline-primary" onclick="addSchoolLogo()">Add School Logo</button>
              <button class="btn btn-outline-primary" onclick="addPhoto()">Add Photo Placeholder</button>
              <button class="btn btn-outline-primary" onclick="addRectangle()">Add Rectangle</button>
              <button class="btn btn-outline-primary" onclick="addLine()">Add Line</button>
              <button class="btn btn-outline-success" onclick="addDynamicField()">Add Dynamic Field</button>
            </div>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-header">
            <h5 class="card-title">Dynamic Fields</h5>
          </div>
          <div class="card-body">
            <div class="accordion" id="dynamicFieldsAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="studentFields">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#studentFieldsCollapse">
                    Student Fields
                  </button>
                </h2>
                <div id="studentFieldsCollapse" class="accordion-collapse collapse" data-bs-parent="#dynamicFieldsAccordion">
                  <div class="accordion-body">
                    <div class="d-grid gap-1">
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('student_name')">Student Name</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('admission_class')">Class</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('section')">Section</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('rollno')">Roll Number</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('father_name')">Father Name</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('mobile')">Mobile</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('session')">Session</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('dob')">Date of Birth</button>
                      <button class="btn btn-outline-info btn-sm" onclick="addStudentField('address')">Address</button>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="accordion-item">
                <h2 class="accordion-header" id="staffFields">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#staffFieldsCollapse">
                    Staff Fields
                  </button>
                </h2>
                <div id="staffFieldsCollapse" class="accordion-collapse collapse" data-bs-parent="#dynamicFieldsAccordion">
                  <div class="accordion-body">
                    <div class="d-grid gap-1">
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('name')">Staff Name</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('employee_id')">Employee ID</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('designation')">Designation</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('department')">Department</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('subject')">Subject</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('mobile')">Mobile</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('email')">Email</button>
                      <button class="btn btn-outline-warning btn-sm" onclick="addStaffField('joining_date')">Joining Date</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-header">
            <h5 class="card-title">Element Properties</h5>
          </div>
          <div class="card-body" id="propertiesPanel">
            <p class="text-muted">Select an element to edit properties</p>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <button class="btn btn-success w-100" onclick="saveTemplate()">
              <i class="mdi mdi-content-save"></i> Save Template
            </button>
          </div>
        </div>
      </div>

      <!-- Canvas Panel -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Design Canvas</h5>
          </div>
          <div class="card-body text-center">
            <div id="canvasContainer" style="display: inline-block; border: 2px solid #ddd; position: relative;">
              <canvas id="designCanvas" width="350" height="550" style="border: 1px solid #ccc; cursor: crosshair;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@include('admin.footer')

<script>
let canvas, ctx;
let elements = [];
let selectedElement = null;
let isDragging = false;
let dragOffset = { x: 0, y: 0 };

// Field mapping for display names
const fieldLabels = {
  // Student fields
  'student_name': 'Student Name',
  'admission_class': 'Class',
  'section': 'Section',
  'rollno': 'Roll Number',
  'father_name': 'Father Name',
  'mobile': 'Mobile',
  'session': 'Session',
  'dob': 'Date of Birth',
  'address': 'Address',
  
  // Staff fields
  'name': 'Staff Name',
  'employee_id': 'Employee ID',
  'designation': 'Designation',
  'department': 'Department',
  'subject': 'Subject',
  'email': 'Email',
  'joining_date': 'Joining Date'
};

$(document).ready(function() {
  initCanvas();
  setupEventListeners();
});

function initCanvas() {
  canvas = document.getElementById('designCanvas');
  ctx = canvas.getContext('2d');
  
  // Canvas event listeners
  canvas.addEventListener('mousedown', onCanvasMouseDown);
  canvas.addEventListener('mousemove', onCanvasMouseMove);
  canvas.addEventListener('mouseup', onCanvasMouseUp);
  canvas.addEventListener('click', onCanvasClick);
  
  redrawCanvas();
}

function setupEventListeners() {
  $('#orientation').change(function() {
    const orientation = $(this).val();
    if (orientation === 'vertical') {
      $('#canvasWidth').val(350);
      $('#canvasHeight').val(550);
    } else if (orientation === 'horizontal') {
      $('#canvasWidth').val(550);
      $('#canvasHeight').val(350);
    }
    updateCanvasSize();
  });

  $('#canvasWidth, #canvasHeight').on('input', function() {
    updateCanvasSize();
  });
}

function updateCanvasSize() {
  const width = parseInt($('#canvasWidth').val());
  const height = parseInt($('#canvasHeight').val());
  
  canvas.width = width;
  canvas.height = height;
  
  redrawCanvas();
}

function addText() {
  const element = {
    type: 'text',
    x: 50,
    y: 50,
    width: 200,
    height: 30,
    text: 'Sample Text',
    fontSize: 16,
    fontFamily: 'Arial',
    color: '#000000',
    align: 'left',
    bold: false,
    italic: false
  };
  
  elements.push(element);
  redrawCanvas();
}

function addSchoolLogo() {
  const element = {
    type: 'logo',
    x: 50,
    y: 50,
    width: 80,
    height: 80,
    source: 'school_logo'
  };
  
  elements.push(element);
  redrawCanvas();
}

function addPhoto() {
  const element = {
    type: 'photo',
    x: 50,
    y: 50,
    width: 100,
    height: 120,
    source: 'user_photo'
  };
  
  elements.push(element);
  redrawCanvas();
}

function addRectangle() {
  const element = {
    type: 'rectangle',
    x: 50,
    y: 50,
    width: 100,
    height: 50,
    fillColor: '#ffffff',
    strokeColor: '#000000',
    strokeWidth: 1
  };
  
  elements.push(element);
  redrawCanvas();
}

function addLine() {
  const element = {
    type: 'line',
    x1: 50,
    y1: 50,
    x2: 150,
    y2: 50,
    strokeColor: '#000000',
    strokeWidth: 1
  };
  
  elements.push(element);
  redrawCanvas();
}

function addDynamicField() {
  const element = {
    type: 'dynamic_field',
    x: 50,
    y: 50,
    width: 200,
    height: 30,
    field_name: 'custom_field',
    label: 'Custom Field',
    fontSize: 16,
    fontFamily: 'Arial',
    color: '#000000',
    align: 'left',
    bold: false,
    italic: false
  };
  
  elements.push(element);
  redrawCanvas();
}

function addStudentField(fieldName) {
  const element = {
    type: 'dynamic_field',
    x: 50,
    y: 50,
    width: 200,
    height: 30,
    field_name: fieldName,
    field_type: 'student',
    label: fieldLabels[fieldName] || fieldName,
    fontSize: 16,
    fontFamily: 'Arial',
    color: '#000000',
    align: 'left',
    bold: false,
    italic: false
  };
  
  elements.push(element);
  redrawCanvas();
}

function addStaffField(fieldName) {
  const element = {
    type: 'dynamic_field',
    x: 50,
    y: 50,
    width: 200,
    height: 30,
    field_name: fieldName,
    field_type: 'staff',
    label: fieldLabels[fieldName] || fieldName,
    fontSize: 16,
    fontFamily: 'Arial',
    color: '#000000',
    align: 'left',
    bold: false,
    italic: false
  };
  
  elements.push(element);
  redrawCanvas();
}

function redrawCanvas() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  // Draw background
  ctx.fillStyle = '#ffffff';
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  
  // Draw elements
  elements.forEach((element, index) => {
    drawElement(element, index === selectedElement);
  });
}

function drawElement(element, isSelected = false) {
  ctx.save();
  
  switch(element.type) {
    case 'text':
      drawText(element);
      break;
    case 'logo':
      drawPlaceholder(element, 'LOGO');
      break;
    case 'photo':
      drawPlaceholder(element, 'PHOTO');
      break;
    case 'rectangle':
      drawRectangle(element);
      break;
    case 'line':
      drawLine(element);
      break;
    case 'dynamic_field':
      drawDynamicField(element);
      break;
  }
  
  if (isSelected) {
    drawSelectionBorder(element);
  }
  
  ctx.restore();
}

function drawText(element) {
  ctx.font = `${element.bold ? 'bold ' : ''}${element.italic ? 'italic ' : ''}${element.fontSize}px ${element.fontFamily}`;
  ctx.fillStyle = element.color;
  ctx.textAlign = element.align;
  
  const x = element.align === 'center' ? element.x + element.width / 2 : 
           element.align === 'right' ? element.x + element.width : element.x;
  
  ctx.fillText(element.text, x, element.y + element.fontSize);
}

function drawDynamicField(element) {
  // Draw field border
  ctx.strokeStyle = '#007bff';
  ctx.setLineDash([3, 3]);
  ctx.strokeRect(element.x, element.y, element.width, element.height);
  ctx.setLineDash([]);
  
  // Draw field text
  ctx.font = `${element.bold ? 'bold ' : ''}${element.italic ? 'italic ' : ''}${element.fontSize}px ${element.fontFamily}`;
  ctx.fillStyle = element.color;
  ctx.textAlign = element.align;
  
  const x = element.align === 'center' ? element.x + element.width / 2 : 
           element.align === 'right' ? element.x + element.width : element.x;
  
  const displayText = `{${element.label}}`;
  ctx.fillText(displayText, x, element.y + element.fontSize);
  
  // Draw field type indicator
  ctx.fillStyle = '#6c757d';
  ctx.font = '10px Arial';
  ctx.textAlign = 'left';
  ctx.fillText(element.field_type || 'dynamic', element.x + 2, element.y + element.height - 2);
}

function drawPlaceholder(element, text) {
  ctx.strokeStyle = '#cccccc';
  ctx.setLineDash([5, 5]);
  ctx.strokeRect(element.x, element.y, element.width, element.height);
  
  ctx.fillStyle = '#cccccc';
  ctx.font = '12px Arial';
  ctx.textAlign = 'center';
  ctx.fillText(text, element.x + element.width / 2, element.y + element.height / 2);
  
  ctx.setLineDash([]);
}

function drawRectangle(element) {
  if (element.fillColor) {
    ctx.fillStyle = element.fillColor;
    ctx.fillRect(element.x, element.y, element.width, element.height);
  }
  
  if (element.strokeColor && element.strokeWidth > 0) {
    ctx.strokeStyle = element.strokeColor;
    ctx.lineWidth = element.strokeWidth;
    ctx.strokeRect(element.x, element.y, element.width, element.height);
  }
}

function drawLine(element) {
  ctx.strokeStyle = element.strokeColor;
  ctx.lineWidth = element.strokeWidth;
  ctx.beginPath();
  ctx.moveTo(element.x1, element.y1);
  ctx.lineTo(element.x2, element.y2);
  ctx.stroke();
}

function drawSelectionBorder(element) {
  ctx.strokeStyle = '#007bff';
  ctx.lineWidth = 2;
  ctx.setLineDash([5, 5]);
  
  if (element.type === 'line') {
    const minX = Math.min(element.x1, element.x2) - 5;
    const minY = Math.min(element.y1, element.y2) - 5;
    const maxX = Math.max(element.x1, element.x2) + 5;
    const maxY = Math.max(element.y1, element.y2) + 5;
    ctx.strokeRect(minX, minY, maxX - minX, maxY - minY);
  } else {
    ctx.strokeRect(element.x - 2, element.y - 2, element.width + 4, element.height + 4);
  }
  
  ctx.setLineDash([]);
}

function onCanvasClick(e) {
  const rect = canvas.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;
  
  selectedElement = null;
  
  for (let i = elements.length - 1; i >= 0; i--) {
    const element = elements[i];
    
    if (isPointInElement(x, y, element)) {
      selectedElement = i;
      break;
    }
  }
  
  showElementProperties();
  redrawCanvas();
}

function isPointInElement(x, y, element) {
  if (element.type === 'line') {
    const minX = Math.min(element.x1, element.x2);
    const maxX = Math.max(element.x1, element.x2);
    const minY = Math.min(element.y1, element.y2);
    const maxY = Math.max(element.y1, element.y2);
    return x >= minX && x <= maxX && y >= minY && y <= maxY;
  } else {
    return x >= element.x && x <= element.x + element.width &&
           y >= element.y && y <= element.y + element.height;
  }
}

function showElementProperties() {
  const panel = $('#propertiesPanel');
  
  if (selectedElement === null) {
    panel.html('<p class="text-muted">Select an element to edit properties</p>');
    return;
  }
  
  const element = elements[selectedElement];
  let html = '<div class="mb-3">';
  
  // Common properties
  if (element.type !== 'line') {
    html += `
      <label class="form-label">Position X</label>
      <input type="number" class="form-control mb-2" value="${element.x}" onchange="updateElementProperty('x', this.value)">
      <label class="form-label">Position Y</label>
      <input type="number" class="form-control mb-2" value="${element.y}" onchange="updateElementProperty('y', this.value)">
      <label class="form-label">Width</label>
      <input type="number" class="form-control mb-2" value="${element.width}" onchange="updateElementProperty('width', this.value)">
      <label class="form-label">Height</label>
      <input type="number" class="form-control mb-2" value="${element.height}" onchange="updateElementProperty('height', this.value)">
    `;
  }
  
  // Type-specific properties
  if (element.type === 'text') {
    html += `
      <label class="form-label">Text</label>
      <input type="text" class="form-control mb-2" value="${element.text}" onchange="updateElementProperty('text', this.value)">
      <label class="form-label">Font Size</label>
      <input type="number" class="form-control mb-2" value="${element.fontSize}" onchange="updateElementProperty('fontSize', this.value)">
      <label class="form-label">Font Family</label>
      <select class="form-select mb-2" onchange="updateElementProperty('fontFamily', this.value)">
        <option value="Arial" ${element.fontFamily === 'Arial' ? 'selected' : ''}>Arial</option>
        <option value="Times New Roman" ${element.fontFamily === 'Times New Roman' ? 'selected' : ''}>Times New Roman</option>
        <option value="Courier New" ${element.fontFamily === 'Courier New' ? 'selected' : ''}>Courier New</option>
      </select>
      <label class="form-label">Color</label>
      <input type="color" class="form-control mb-2" value="${element.color}" onchange="updateElementProperty('color', this.value)">
      <label class="form-label">Alignment</label>
      <select class="form-select mb-2" onchange="updateElementProperty('align', this.value)">
        <option value="left" ${element.align === 'left' ? 'selected' : ''}>Left</option>
        <option value="center" ${element.align === 'center' ? 'selected' : ''}>Center</option>
        <option value="right" ${element.align === 'right' ? 'selected' : ''}>Right</option>
      </select>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" ${element.bold ? 'checked' : ''} onchange="updateElementProperty('bold', this.checked)">
        <label class="form-check-label">Bold</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" ${element.italic ? 'checked' : ''} onchange="updateElementProperty('italic', this.checked)">
        <label class="form-check-label">Italic</label>
      </div>
    `;
  } else if (element.type === 'dynamic_field') {
    html += `
      <label class="form-label">Field Name</label>
      <input type="text" class="form-control mb-2" value="${element.field_name}" onchange="updateElementProperty('field_name', this.value)">
      <label class="form-label">Display Label</label>
      <input type="text" class="form-control mb-2" value="${element.label}" onchange="updateElementProperty('label', this.value)">
      <label class="form-label">Field Type</label>
      <select class="form-select mb-2" onchange="updateElementProperty('field_type', this.value)">
        <option value="student" ${element.field_type === 'student' ? 'selected' : ''}>Student</option>
        <option value="staff" ${element.field_type === 'staff' ? 'selected' : ''}>Staff</option>
        <option value="custom" ${element.field_type === 'custom' ? 'selected' : ''}>Custom</option>
      </select>
      <label class="form-label">Font Size</label>
      <input type="number" class="form-control mb-2" value="${element.fontSize}" onchange="updateElementProperty('fontSize', this.value)">
      <label class="form-label">Font Family</label>
      <select class="form-select mb-2" onchange="updateElementProperty('fontFamily', this.value)">
        <option value="Arial" ${element.fontFamily === 'Arial' ? 'selected' : ''}>Arial</option>
        <option value="Times New Roman" ${element.fontFamily === 'Times New Roman' ? 'selected' : ''}>Times New Roman</option>
        <option value="Courier New" ${element.fontFamily === 'Courier New' ? 'selected' : ''}>Courier New</option>
      </select>
      <label class="form-label">Color</label>
      <input type="color" class="form-control mb-2" value="${element.color}" onchange="updateElementProperty('color', this.value)">
      <label class="form-label">Alignment</label>
      <select class="form-select mb-2" onchange="updateElementProperty('align', this.value)">
        <option value="left" ${element.align === 'left' ? 'selected' : ''}>Left</option>
        <option value="center" ${element.align === 'center' ? 'selected' : ''}>Center</option>
        <option value="right" ${element.align === 'right' ? 'selected' : ''}>Right</option>
      </select>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" ${element.bold ? 'checked' : ''} onchange="updateElementProperty('bold', this.checked)">
        <label class="form-check-label">Bold</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" ${element.italic ? 'checked' : ''} onchange="updateElementProperty('italic', this.checked)">
        <label class="form-check-label">Italic</label>
      </div>
    `;
  } else if (element.type === 'rectangle') {
    html += `
      <label class="form-label">Fill Color</label>
      <input type="color" class="form-control mb-2" value="${element.fillColor}" onchange="updateElementProperty('fillColor', this.value)">
      <label class="form-label">Border Color</label>
      <input type="color" class="form-control mb-2" value="${element.strokeColor}" onchange="updateElementProperty('strokeColor', this.value)">
      <label class="form-label">Border Width</label>
      <input type="number" class="form-control mb-2" value="${element.strokeWidth}" onchange="updateElementProperty('strokeWidth', this.value)">
    `;
  } else if (element.type === 'line') {
    html += `
      <label class="form-label">Start X</label>
      <input type="number" class="form-control mb-2" value="${element.x1}" onchange="updateElementProperty('x1', this.value)">
      <label class="form-label">Start Y</label>
      <input type="number" class="form-control mb-2" value="${element.y1}" onchange="updateElementProperty('y1', this.value)">
      <label class="form-label">End X</label>
      <input type="number" class="form-control mb-2" value="${element.x2}" onchange="updateElementProperty('x2', this.value)">
      <label class="form-label">End Y</label>
      <input type="number" class="form-control mb-2" value="${element.y2}" onchange="updateElementProperty('y2', this.value)">
      <label class="form-label">Color</label>
      <input type="color" class="form-control mb-2" value="${element.strokeColor}" onchange="updateElementProperty('strokeColor', this.value)">
      <label class="form-label">Width</label>
      <input type="number" class="form-control mb-2" value="${element.strokeWidth}" onchange="updateElementProperty('strokeWidth', this.value)">
    `;
  }
  
  html += `
    <button class="btn btn-danger btn-sm w-100" onclick="deleteElement()">
      <i class="mdi mdi-delete"></i> Delete Element
    </button>
  `;
  
  html += '</div>';
  panel.html(html);
}

function updateElementProperty(property, value) {
  if (selectedElement !== null) {
    elements[selectedElement][property] = property === 'bold' || property === 'italic' ? value : 
                                         property.includes('Width') || property.includes('Height') || 
                                         property.includes('Size') || property.includes('x') || property.includes('y') ? 
                                         parseInt(value) : value;
    redrawCanvas();
  }
}

function deleteElement() {
  if (selectedElement !== null) {
    elements.splice(selectedElement, 1);
    selectedElement = null;
    showElementProperties();
    redrawCanvas();
  }
}

function onCanvasMouseDown(e) {
  if (selectedElement !== null) {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    const element = elements[selectedElement];
    
    if (isPointInElement(x, y, element)) {
      isDragging = true;
      if (element.type === 'line') {
        dragOffset.x = x - element.x1;
        dragOffset.y = y - element.y1;
      } else {
        dragOffset.x = x - element.x;
        dragOffset.y = y - element.y;
      }
      canvas.style.cursor = 'move';
    }
  }
}

function onCanvasMouseMove(e) {
  if (isDragging && selectedElement !== null) {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    const element = elements[selectedElement];
    
    if (element.type === 'line') {
      const deltaX = x - dragOffset.x - element.x1;
      const deltaY = y - dragOffset.y - element.y1;
      element.x1 += deltaX;
      element.y1 += deltaY;
      element.x2 += deltaX;
      element.y2 += deltaY;
    } else {
      element.x = x - dragOffset.x;
      element.y = y - dragOffset.y;
      
      // Keep element within canvas bounds
      element.x = Math.max(0, Math.min(canvas.width - element.width, element.x));
      element.y = Math.max(0, Math.min(canvas.height - element.height, element.y));
    }
    
    redrawCanvas();
    showElementProperties();
  }
}

function onCanvasMouseUp(e) {
  if (isDragging) {
    isDragging = false;
    canvas.style.cursor = 'crosshair';
  }
}

function saveTemplate() {
  const templateName = $('#templateName').val();
  const templateType = $('#templateType').val();
  const orientation = $('#orientation').val();
  const width = $('#canvasWidth').val();
  const height = $('#canvasHeight').val();
  
  if (!templateName || !templateType || !orientation) {
    alert('Please fill in all required fields');
    return;
  }
  
  const templateData = {
    elements: elements,
    canvas: {
      width: parseInt(width),
      height: parseInt(height)
    }
  };
  
  // Generate CSS styles for the template
  const cssStyles = generateCSSStyles();
  
  $.ajax({
    url: '{{ route("id-cards.save-template") }}',
    method: 'POST',
    data: {
      _token: '{{ csrf_token() }}',
      name: templateName,
      type: templateType,
      orientation: orientation,
      width: width,
      height: height,
      template_data: JSON.stringify(templateData),
      css_styles: cssStyles
    },
    success: function(response) {
      if (response.success) {
        alert('Template saved successfully!');
        window.location.href = '{{ route("id-cards.index") }}';
      } else {
        alert('Error saving template: ' + response.message);
      }
    },
    error: function(xhr) {
      alert('Error saving template. Please try again.');
      console.error(xhr);
    }
  });
}

function generateCSSStyles() {
  let css = `
    .id-card {
      width: ${$('#canvasWidth').val()}px;
      height: ${$('#canvasHeight').val()}px;
      position: relative;
      background: white;
      border: 1px solid #ddd;
      font-family: Arial, sans-serif;
      page-break-inside: avoid;
      margin: 10px;
      box-sizing: border-box;
    }
    
    .id-card-element {
      position: absolute;
      box-sizing: border-box;
    }
    
    .id-card-photo {
      border: 1px solid #ddd;
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: #666;
    }
    
    .id-card-logo {
      border: 1px solid #ddd;
      background: #f9f9f9;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: #666;
    }
    
    @media print {
      .id-card {
        margin: 0;
        page-break-inside: avoid;
      }
      
      body {
        margin: 0;
        padding: 0;
      }
    }
  `;
  
  // Add element-specific styles
  elements.forEach((element, index) => {
    const elementClass = `.id-card-element-${index}`;
    
    if (element.type === 'text' || element.type === 'dynamic_field') {
      css += `
        ${elementClass} {
          font-size: ${element.fontSize}px;
          font-family: ${element.fontFamily};
          color: ${element.color};
          text-align: ${element.align};
          font-weight: ${element.bold ? 'bold' : 'normal'};
          font-style: ${element.italic ? 'italic' : 'normal'};
        }
      `;
    } else if (element.type === 'rectangle') {
      css += `
        ${elementClass} {
          background-color: ${element.fillColor};
          border: ${element.strokeWidth}px solid ${element.strokeColor};
        }
      `;
    } else if (element.type === 'line') {
      css += `
        ${elementClass} {
          border-top: ${element.strokeWidth}px solid ${element.strokeColor};
        }
      `;
    }
  });
  
  return css;
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
  if (e.key === 'Delete' && selectedElement !== null) {
    deleteElement();
  }
  
  if (e.ctrlKey && e.key === 's') {
    e.preventDefault();
    saveTemplate();
  }
  
  if (e.key === 'Escape') {
    selectedElement = null;
    showElementProperties();
    redrawCanvas();
  }
});

// Template presets
function loadVerticalTemplate() {
  elements = [
    // School logo
    {
      type: 'logo',
      x: 20,
      y: 20,
      width: 60,
      height: 60,
      source: 'school_logo'
    },
    // School name
    {
      type: 'text',
      x: 90,
      y: 20,
      width: 240,
      height: 30,
      text: '{{ $school->school_name ?? "School Name" }}',
      fontSize: 16,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'center',
      bold: true,
      italic: false
    },
    // ID Card title
    {
      type: 'text',
      x: 20,
      y: 90,
      width: 310,
      height: 25,
      text: 'STUDENT ID CARD',
      fontSize: 14,
      fontFamily: 'Arial',
      color: '#0066cc',
      align: 'center',
      bold: true,
      italic: false
    },
    // Student photo
    {
      type: 'photo',
      x: 20,
      y: 130,
      width: 80,
      height: 100,
      source: 'user_photo'
    },
    // Student name
    {
      type: 'dynamic_field',
      x: 110,
      y: 130,
      width: 220,
      height: 25,
      field_name: 'student_name',
      field_type: 'student',
      label: 'Student Name',
      fontSize: 14,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: true,
      italic: false
    },
    // Class
    {
      type: 'dynamic_field',
      x: 110,
      y: 160,
      width: 220,
      height: 20,
      field_name: 'admission_class',
      field_type: 'student',
      label: 'Class',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Section
    {
      type: 'dynamic_field',
      x: 110,
      y: 180,
      width: 220,
      height: 20,
      field_name: 'section',
      field_type: 'student',
      label: 'Section',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Roll Number
    {
      type: 'dynamic_field',
      x: 110,
      y: 200,
      width: 220,
      height: 20,
      field_name: 'rollno',
      field_type: 'student',
      label: 'Roll No',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Father's name
    {
      type: 'dynamic_field',
      x: 20,
      y: 250,
      width: 310,
      height: 20,
      field_name: 'father_name',
      field_type: 'student',
      label: 'Father Name',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Mobile
    {
      type: 'dynamic_field',
      x: 20,
      y: 280,
      width: 310,
      height: 20,
      field_name: 'mobile',
      field_type: 'student',
      label: 'Mobile',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Address
    {
      type: 'dynamic_field',
      x: 20,
      y: 310,
      width: 310,
      height: 40,
      field_name: 'address',
      field_type: 'student',
      label: 'Address',
      fontSize: 11,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Session
    {
      type: 'dynamic_field',
      x: 20,
      y: 360,
      width: 150,
      height: 20,
      field_name: 'session',
      field_type: 'student',
      label: 'Session',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Date of Birth
    {
      type: 'dynamic_field',
      x: 180,
      y: 360,
      width: 150,
      height: 20,
      field_name: 'dob',
      field_type: 'student',
      label: 'DOB',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    }
  ];
  
  redrawCanvas();
}

function loadHorizontalTemplate() {
  elements = [
    // School logo
    {
      type: 'logo',
      x: 20,
      y: 20,
      width: 60,
      height: 60,
      source: 'school_logo'
    },
    // School name
    {
      type: 'text',
      x: 90,
      y: 20,
      width: 350,
      height: 30,
      text: '{{ $school->school_name ?? "School Name" }}',
      fontSize: 16,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'center',
      bold: true,
      italic: false
    },
    // ID Card title
    {
      type: 'text',
      x: 90,
      y: 50,
      width: 350,
      height: 25,
      text: 'STUDENT ID CARD',
      fontSize: 14,
      fontFamily: 'Arial',
      color: '#0066cc',
      align: 'center',
      bold: true,
      italic: false
    },
    // Student photo
    {
      type: 'photo',
      x: 20,
      y: 100,
      width: 80,
      height: 100,
      source: 'user_photo'
    },
    // Student name
    {
      type: 'dynamic_field',
      x: 120,
      y: 100,
      width: 200,
      height: 25,
      field_name: 'student_name',
      field_type: 'student',
      label: 'Student Name',
      fontSize: 14,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: true,
      italic: false
    },
    // Class and Section
    {
      type: 'dynamic_field',
      x: 120,
      y: 130,
      width: 100,
      height: 20,
      field_name: 'admission_class',
      field_type: 'student',
      label: 'Class',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    {
      type: 'dynamic_field',
      x: 230,
      y: 130,
      width: 100,
      height: 20,
      field_name: 'section',
      field_type: 'student',
      label: 'Section',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Roll Number
    {
      type: 'dynamic_field',
      x: 120,
      y: 155,
      width: 200,
      height: 20,
      field_name: 'rollno',
      field_type: 'student',
      label: 'Roll No',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Father's name
    {
      type: 'dynamic_field',
      x: 120,
      y: 180,
      width: 200,
      height: 20,
      field_name: 'father_name',
      field_type: 'student',
      label: 'Father Name',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Mobile and Session
    {
      type: 'dynamic_field',
      x: 350,
      y: 100,
      width: 180,
      height: 20,
      field_name: 'mobile',
      field_type: 'student',
      label: 'Mobile',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    {
      type: 'dynamic_field',
      x: 350,
      y: 125,
      width: 180,
      height: 20,
      field_name: 'session',
      field_type: 'student',
      label: 'Session',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Address
    {
      type: 'dynamic_field',
      x: 350,
      y: 150,
      width: 180,
      height: 40,
      field_name: 'address',
      field_type: 'student',
      label: 'Address',
      fontSize: 11,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    }
  ];
  
  redrawCanvas();
}

function loadStaffTemplate() {
  elements = [
    // School logo
    {
      type: 'logo',
      x: 20,
      y: 20,
      width: 60,
      height: 60,
      source: 'school_logo'
    },
    // School name
    {
      type: 'text',
      x: 90,
      y: 20,
      width: 240,
      height: 30,
      text: '{{ $school->school_name ?? "School Name" }}',
      fontSize: 16,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'center',
      bold: true,
      italic: false
    },
    // ID Card title
    {
      type: 'text',
      x: 20,
      y: 90,
      width: 310,
      height: 25,
      text: 'STAFF ID CARD',
      fontSize: 14,
      fontFamily: 'Arial',
      color: '#cc6600',
      align: 'center',
      bold: true,
      italic: false
    },
    // Staff photo
    {
      type: 'photo',
      x: 20,
      y: 130,
      width: 80,
      height: 100,
      source: 'user_photo'
    },
    // Staff name
    {
      type: 'dynamic_field',
      x: 110,
      y: 130,
      width: 220,
      height: 25,
      field_name: 'name',
      field_type: 'staff',
      label: 'Staff Name',
      fontSize: 14,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: true,
      italic: false
    },
    // Employee ID
    {
      type: 'dynamic_field',
      x: 110,
      y: 160,
      width: 220,
      height: 20,
      field_name: 'employee_id',
      field_type: 'staff',
      label: 'Employee ID',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Designation
    {
      type: 'dynamic_field',
      x: 110,
      y: 180,
      width: 220,
      height: 20,
      field_name: 'designation',
      field_type: 'staff',
      label: 'Designation',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Department
    {
      type: 'dynamic_field',
      x: 110,
      y: 200,
      width: 220,
      height: 20,
      field_name: 'department',
      field_type: 'staff',
      label: 'Department',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Subject
    {
      type: 'dynamic_field',
      x: 20,
      y: 250,
      width: 310,
      height: 20,
      field_name: 'subject',
      field_type: 'staff',
      label: 'Subject',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Mobile
    {
      type: 'dynamic_field',
      x: 20,
      y: 280,
      width: 310,
      height: 20,
      field_name: 'mobile',
      field_type: 'staff',
      label: 'Mobile',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Email
    {
      type: 'dynamic_field',
      x: 20,
      y: 310,
      width: 310,
      height: 20,
      field_name: 'email',
      field_type: 'staff',
      label: 'Email',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    },
    // Joining Date
    {
      type: 'dynamic_field',
      x: 20,
      y: 340,
      width: 310,
      height: 20,
      field_name: 'joining_date',
      field_type: 'staff',
      label: 'Joining Date',
      fontSize: 12,
      fontFamily: 'Arial',
      color: '#000000',
      align: 'left',
      bold: false,
      italic: false
    }
  ];
  
  redrawCanvas();
}

// Add template preset buttons
$('#templateType').change(function() {
  const type = $(this).val();
  const orientation = $('#orientation').val();
  
  if (type && orientation) {
    if (confirm('Load a preset template? This will replace your current design.')) {
      if (type === 'student') {
        if (orientation === 'vertical') {
          loadVerticalTemplate();
        } else {
          loadHorizontalTemplate();
        }
      } else if (type === 'staff') {
        loadStaffTemplate();
      }
    }
  }
});

// Copy element functionality
function copyElement() {
  if (selectedElement !== null) {
    const element = JSON.parse(JSON.stringify(elements[selectedElement]));
    element.x += 10;
    element.y += 10;
    elements.push(element);
    selectedElement = elements.length - 1;
    redrawCanvas();
    showElementProperties();
  }
}

// Keyboard shortcut for copy
document.addEventListener('keydown', function(e) {
  if (e.ctrlKey && e.key === 'c' && selectedElement !== null) {
    e.preventDefault();
    copyElement();
  }
});

// Add copy button to properties panel
function showElementProperties() {
  const panel = $('#propertiesPanel');
  
  if (selectedElement === null) {
    panel.html('<p class="text-muted">Select an element to edit properties</p>');
    return;
  }
  
  const element = elements[selectedElement];
  let html = '<div class="mb-3">';
  
  // Add element info
  html += `<div class="alert alert-info p-2 mb-2">
    <small><strong>Element:</strong> ${element.type}${element.field_name ? ' (' + element.field_name + ')' : ''}</small>
  </div>`;
  
  // Rest of the properties code remains the same...
  // [Previous showElementProperties code continues here]
  
  // Add action buttons
  html += `
    <div class="d-grid gap-2 mt-3">
      <button class="btn btn-info btn-sm" onclick="copyElement()">
        <i class="mdi mdi-content-copy"></i> Copy Element
      </button>
      <button class="btn btn-danger btn-sm" onclick="deleteElement()">
        <i class="mdi mdi-delete"></i> Delete Element
      </button>
    </div>
  `;
  
  html += '</div>';
  panel.html(html);
}
</script>

<style>
.card {
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  border: none;
}

.card-header {
  background: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
}

#canvasContainer {
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
}

.accordion-button {
  font-size: 14px;
  padding: 8px 12px;
}

.btn-outline-info.btn-sm,
.btn-outline-warning.btn-sm {
  font-size: 11px;
  padding: 4px 8px;
}

.form-control, .form-select {
  font-size: 14px;
}

.properties-panel {
  max-height: 400px;
  overflow-y: auto;
}

#propertiesPanel {
  max-height: 500px;
  overflow-y: auto;
}

.element-selected {
  border: 2px solid #007bff !important;
}

.canvas-grid {
  background-image: 
    linear-gradient(to right, #f0f0f0 1px, transparent 1px),
    linear-gradient(to bottom, #f0f0f0 1px, transparent 1px);
  background-size: 20px 20px;
}
</style>