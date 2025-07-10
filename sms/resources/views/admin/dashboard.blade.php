@include('admin.header')
@include('admin.sidebar')
<style>
  <style>
    .circle-chart {
        width: 80px;
        height: 80px;
    }

    .circle-chart svg {
        width: 100%;
        height: 100%;
    }
</style>

</style>
				<div class="content-wrapper">
					<div class="row">
						<div class="col-sm-4 mb-4 mb-xl-0">
							<div class="d-lg-flex align-items-center">
								<div>
									<h6 class="font-weight-normal mb-2"></h6>
									<h3 class="text-dark font-weight-bold mb-2">Hi, welcome back!</h3>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="d-flex align-items-center justify-content-md-end">
  <div class="pe-1 mb-3 mb-xl-0">
    <button type="button" class="btn btn-outline-inverse-info btn-icon-text" data-bs-toggle="modal" data-bs-target="#howToUseModal">
  How to use SchoolDigi Portal
  <!-- <span class="badge badge-success ms-2">New</span> -->
  <i class="mdi mdi-help-circle btn-icon-append"></i>
</button>

  </div>
</div>

<!-- How to Use Modal -->
<div class="modal fade" id="howToUseModal" tabindex="-1" aria-labelledby="howToUseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="howToUseModalLabel">How to Use SchoolDigi Portal</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ol class="ps-3">
          <li><strong>Login:</strong> Use your registered username and password to log into the portal.</li>
          <li><strong>Dashboard Overview:</strong> View important announcements, recent activity, and quick links.</li>
          <li><strong>Student Admission:</strong> Click on <code>Admission</code> to add new students using the form or upload them in bulk.</li>
          <li><strong>Attendance:</strong> Navigate to the attendance section to mark or view attendance records.</li>
          <li><strong>Exam & Results:</strong> Manage exams, enter marks, and generate result summaries.</li>
          <li><strong>Fee Management:</strong> Add and view student fee details, due payments, and generate receipts.</li>
          <li><strong>Notice Board:</strong> View or publish important notices for students and staff.</li>
          <li><strong>Settings:</strong> Update institute details, manage users, and configure system preferences.</li>
        </ol>
        <p class="mt-3">For any help, contact our support team at <strong>support@schooldigi.com</strong>.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

						</div>
					</div>
					<br>
					<div class="row">
					<div class="col-sm-12 flex-column d-flex stretch-card">
							<div class="row flex-grow">
								<div class="col-sm-3 grid-margin stretch-card">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-lg-8">
													<h3 class="font-weight-bold text-dark">Total Student</h3>
													<div class="d-lg-flex align-items-baseline mb-3">
														<h1 class="text-dark font-weight-bold">{{ $totalStudents ?? 0}}<sup class="font-weight-light"></sup></h1>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="position-relative">
														<img src="images/dashboard/live.png" class="w-100" alt="">
														<div class="live-info badge badge-success">Live</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12 mt-4 mt-lg-0">
													<div class="bg-primary text-white px-4 py-4 card">
														<div class="row">
															<div class="col-sm-6 pl-lg-5">
																<h2>{{ $totalBoys ?? 0}} </h2>
																<p class="mb-0">Total Boys</p>
															</div>
															<div class="col-sm-6 climate-info-border mt-lg-0 mt-2">
																<h2>{{ $totalGirls ?? 0}}</h2>
																<p class="mb-0">Total Girls</p>
															</div>
														</div>
													</div>
												</div>
											</div>
                      @php
                          $total = $totalBoys + $totalGirls;
                          $boysPercent = $total > 0 ? round(($totalBoys / $total) * 100, 1) : 0;
                          $girlsPercent = $total > 0 ? round(($totalGirls / $total) * 100, 1) : 0;

                          $boysColor = $totalBoys > 0 ? '#3d36b5' : '#ffffff'; // blue or white 
                          $girlsColor = $totalGirls > 0 ? '#ff80f7' : '#ffffff'; // pink or white
                      @endphp
                      <div class="row pt-3 mt-md-1">
                        <div class="col">
                          <div class="d-flex purchase-detail-legend align-items-center">
                            <div class="p-2 circle-chart">
                              <svg viewBox="0 0 100 100">
                                <circle r="45" cx="50" cy="50" stroke="#eee" stroke-width="10" fill="none"></circle>
                                <circle r="45" cx="50" cy="50" stroke="{{ $boysColor }}" stroke-width="10"
                                  fill="none"
                                  stroke-dasharray="282"
                                  stroke-dashoffset="{{ 282 - (282 * $boysPercent / 100) }}"
                                  transform="rotate(-90 50 50)">
                                </circle>
                              </svg>
                            </div>
                          <div>
                            <p class="font-weight-medium text-dark text-small">Boys</p>
                            <h5 class="font-weight-bold text-dark mb-0">{{ $boysPercent }}%</h5>
                          </div>
                        </div>
                      </div>

                      <div class="col">
                        <div class="d-flex purchase-detail-legend align-items-center">
                          <div class="p-2 circle-chart">
                            <svg viewBox="0 0 100 100">
                              <circle r="45" cx="50" cy="50" stroke="#eee" stroke-width="10" fill="none"></circle>
                              <circle r="45" cx="50" cy="50" stroke="{{ $girlsColor }}" stroke-width="10"
                                fill="none"
                                stroke-dasharray="282"
                                stroke-dashoffset="{{ 282 - (282 * $girlsPercent / 100) }}"
                                transform="rotate(-90 50 50)">
                              </circle>
                            </svg>
                          </div>
                          <div>
                            <p class="font-weight-medium text-dark text-small">Girls</p>
                            <h5 class="font-weight-bold text-dark mb-0">{{ $girlsPercent }}%</h5>
                          </div>
                        </div>
                      </div>
                    </div>
									</div>
								</div>
							</div>
						
                <div class="col-sm-9 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h3 class="font-weight-bold text-dark text-center mb-4">Category-wise Total Students</h3>
                      <hr>
                      <canvas id="categoryBarChart" height="100"></canvas>
                    </div>
                  </div>
                </div>
              
  					</div>
					
					<div class="col-md-12 grid-margin transparent">
            <h3 style="text-align:center; font-weight:bold; padding:15px;"> Classwise Student</h3>
            <div class="row">
              @php
$allClasses = ['LKG', 'UKG','Nursery', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Tweleth'];
@endphp

<div class="row">
@foreach($allClasses as $index => $class)
  @php
    $counts = $classwiseData[$class] ?? ['boys' => 0, 'girls' => 0];
    $boys = $counts['boys'];
    $girls = $counts['girls'];
    $total = $boys + $girls;
    $chartId = 'classChart' . $index;
  @endphp

  <div class="col-md-4 mb-4">
    <div class="card shadow-sm">
      <div class="card-body d-flex align-items-center">
        <!-- Chart on Left -->
        <div class="flex-shrink-0" style="width: 80px; height: 80px;">
          <canvas id="{{ $chartId }}" width="80" height="80"></canvas>
        </div>

        <!-- Text on Right -->
        <div class="flex-grow-1 pl-4">
          <h5 class="text-dark mb-2" style="font-weight: 600;">{{ $class }} - {{ $total }}</h5>
          <div class="d-flex justify-content-between">
            <span class="text-primary"><i class="mdi mdi-gender-male"></i> Boys: {{ $boys }}</span>
            <span class="text-danger"><i class="mdi mdi-gender-female"></i> Girls: {{ $girls }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach

</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    @foreach($allClasses as $index => $class)
      const ctx{{ $index }} = document.getElementById('classChart{{ $index }}').getContext('2d');
      new Chart(ctx{{ $index }}, {
        type: 'doughnut',
        data: {
          labels: ['Boys', 'Girls'],
          datasets: [{
            data: [{{ $classwiseData[$class]['boys'] ?? 0 }}, {{ $classwiseData[$class]['girls'] ?? 0 }}],
            backgroundColor: ['#3d36b5', '#ff80f7'],
            borderWidth: 2
          }]
        },
        options: {
          responsive: false,
          maintainAspectRatio: false,
          cutout: '65%',
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return context.label + ': ' + context.parsed + ' students';
                }
              }
            }
          }
        }
      });
    @endforeach
  });
</script>



		@php
    function className($value) {
        return match ($value) {
            '1' =>'First',
            '2' => 'Second',
            '3' => 'Third',
            '4' => 'Fourth',
            '5' => 'Fifth',
            '6' => 'Sixth',
            '7' => 'Seventh',
            '8' => 'Eighth',
            '9' => 'Ninth',
            '10' => 'Tenth',
            '11' => 'Eleventh',
            '12' => 'Tweleth',
            default => $value
        };
    }
@endphp
			
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h3 class="font-weight-bold text-dark text-center mb-4">Third Language Wise Total Student's</h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Class</th>
              <th>Punjabi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($thirdLanguageSummary as $class => $data)
              <tr>
                <td class="py-1">
                  {{ className($class) }}
                </td>
                <td class="py-1 text-center">
                  {{ $data['total'] }}<br>(B-{{ $data['boys'] }})<br>(G-{{ $data['girls'] }})
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



@php
  function className1($value) {
      return [
          'LKG' => 'LKG',
          'UKG' => 'UKG',
          'Nursery' => 'Nursery',
          '1' => 'First',
          '2' => 'Second',
          '3' => 'Third',
          '4' => 'Fourth',
          '5' => 'Fifth',
          '6' => 'Sixth',
          '7' => 'Seventh',
          '8' => 'Eighth',
          '9' => 'Ninth',
          '10' => 'Tenth',
          '11' => 'Eleventh',
          '12' => 'Tweleth',
      ][$value] ?? $value;
  }
@endphp

<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h3 class="font-weight-bold text-dark text-center mb-4">Religion-Wise Total Student's</h3>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Class</th>
              <th>Hindu</th>
              <th>Muslim</th>
              <th>Sikh</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($religionSummary as $class => $data)
              <tr>
                <td class="py-1">{{ className1($class) }}</td>
                @foreach (['Hindu', 'Muslim', 'Sikh'] as $religion)
                  <td class="py-1 text-center">
                    {{ $data[$religion]['total'] }}<br>
                    (B-{{ $data[$religion]['boys'] }})<br>
                    (G-{{ $data[$religion]['girls'] }})
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
@include('admin.footer')
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script> -->

<script>
  const ctx = document.getElementById('categoryBarChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        'SC (Scheduled Caste)',
        'ST (Scheduled Tribes)',
        'OBC (Other Backward Classes)',
        'GENERAL',
        'MINORITY'
      ],
      datasets: [
        {
          label: 'Boys',
          data: [
            {{ $categoryBoys['SC'] ?? 0 }},
            {{ $categoryBoys['ST'] ?? 0 }},
            {{ $categoryBoys['OBC'] ?? 0 }},
            {{ $categoryBoys['GENERAL'] ?? 0 }},
            {{ $categoryBoys['MINORITY'] ?? 0 }}
          ],
          backgroundColor: '#3d36b5',
          borderRadius: 10,
          datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#ffffff',
            font: {
              weight: 'bold'
            },
            formatter: (value) => value + ' Boys'
          }
        },
        {
          label: 'Girls',
          data: [
            {{ $categoryGirls['SC'] ?? 0 }},
            {{ $categoryGirls['ST'] ?? 0 }},
            {{ $categoryGirls['OBC'] ?? 0 }},
            {{ $categoryGirls['GEN'] ?? 0 }},
            {{ $categoryGirls['MIN'] ?? 0 }}
          ],
          backgroundColor: '#ff80f7',
          borderRadius: 10,
          datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#000000',
            font: {
              weight: 'bold'
            },
            formatter: (value) => value + ' Girls'
          }
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        tooltip: {
          callbacks: {
            title: (tooltipItems) => '👤 ' + tooltipItems[0].label
          }
        },
        datalabels: {
          // Required but handled per dataset
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { precision: 0 }
        }
      }
    },
    plugins: [ChartDataLabels]
  });
</script>
