{{-- File: resources/views/admin/id_cards/edit.blade.php --}}

@include('admin.header')
@include('admin.sidebar')

<div class="main-panel">
  <div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="font-weight-bold text-dark">Edit ID Card Template</h4>
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
                <input type="text" class="form-control" id="templateName" value="{{ $template->name }}" required>
              </div>
              
              <div class="mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" id="templateType" required>
                  <option value="student" {{ $template->type == 'student' ? 'selected' : '' }}>Student</option>
                  <option value="staff" {{ $template->type == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="form-label">Orientation</label>
                <select class="form-select" id="orientation" required>
                  <option value="vertical" {{ $template->orientation == 'vertical' ? 'selected' : '' }}>Vertical</option>
                  <option value="horizontal" {{ $template->orientation == 'horizontal' ? 'selected' : '' }}>Horizontal</option>
                </select>
              </div>
              
              <div class="row">
                <div class="col-6">
                  <label class="form-label">Width (px)</label>
                  <input type="number" class="form-control" id="canvasWidth" value="{{ $template->width }}" min="200" max="600">
                </div>
                <div class="col-6">
                  <label class="form-label">Height (px)</label>
                  <input type="number" class="form-control" id="canvasHeight" value="{{ $template->height }}" min="300" max="800">
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
            <button class="btn btn-success w-100" onclick="updateTemplate()">
              <i class="mdi mdi-content-save"></i> Update Template
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
              <canvas id="designCanvas" width="{{ $template->width }}" height="{{ $template->height }}" style="border: 1px solid #ccc; cursor: crosshair;"></canvas>
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
let elements = @json($template->template_data['elements'] ?? []);
let selectedElement = null;
let isDragging = false;
let dragOffset = { x: 0, y: 0 };

$(document).ready(function() {
  initCanvas();
  setupEventListeners();
  redrawCanvas();
});

function initCanvas() {
  canvas = document.getElementById('designCanvas');
  ctx = canvas.getContext('2d');
  
  // Canvas event listeners
  canvas.addEventListener('mousedown', onCanvasMouseDown);
  canvas.addEventListener('mousemove', onCanvasMouseMove);
  canvas.addEventListener('mouseup', onCanvasMouseUp);
  canvas.addEventListener('click', onCanvasClick);
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

// Add design elements functions
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

function updateTemplate() {
  const templateData = {
    name: $('#templateName').val(),
    type: $('#templateType').val(),
    orientation: $('#orientation').val(),
    width: parseInt($('#canvasWidth').val()),
    height: parseInt($('#canvasHeight').val()),
    template_data: JSON.stringify({
      elements: elements
    })
  };

  $.ajax({
    url: "{{ route('id-cards.update', $template->id) }}",
    method: 'PUT',
    data: templateData,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      if (response.success) {
        alert('Template updated successfully!');
        window.location.href = "{{ route('id-cards.index') }}";
      }
    },
    error: function(xhr) {
      alert('Error updating template: ' + xhr.responseText);
    }
  });
}
</script>