<!-- Student Bulk Upload Modal -->
<div class="modal fade" id="studentUploadModal" tabindex="-1" aria-labelledby="studentUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="studentUploadModalLabel">Upload Students (Bulk)</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="back">
          <div class="col-md-10 grid-margin stretch-card" style="margin: 0 auto;">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title text-center mb-4">Upload Student CSV File</h4>
                <form action="{{ route('admin.students.upload') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Import File</label>
                    <div class="col-sm-9">
                      <input type="file" name="students_csv" required class="form-control">
                      <br>
                      <span class="text-danger h4"></span>
                    </div>
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-primary me-2" name="submit">Import Students File</button>
                  </div>
                </form>
              </div>
              <div class="form-group row">
                <div class="col-sm-11" style="margin: 0 auto;">
                  <h4><a href="card/student.csv" style="font-weight:700" download="student_sample.csv">Download Sample File</a></h4>
                  <ul style="color:#464dee; font-weight:700; border:1px solid gray; border-radius:7px; padding:40px; background:#eae9fb;">
                    <h4>फाइल को अपलोड करने से पहले दिशा निर्देश जरुर पढ़े</h4>
                    <li>आर टी ई के पोर्टल के विद्यार्थी मेनू से विद्यार्थी डाटा एंट्री (सशुल्क) से कक्षा wise डाटा कॉपी करके नई शीट में पेस्ट स्पेशल करें और Text का चुनाव करें।</li>
                    <li>जन्म तिथि को YYYY-MM-DD के फॉर्मेट में लिखें।</li>
                    <li>RTE के पोर्टल से डाउनलोड डाटा को सामान्य Excel फाइल में पेस्ट स्पेसल करने के बाद निम्न कॉलम डिलीट कर दें: <strong>NIC Student ID, Aadhar Verified, CWSN Facility, Type of Disability, Action</strong> पूरे कॉलम को सेलेक्ट करके डिलीट करें।</li>
                    <li>इसके बाद पूरी फाइल को कॉपी करके Download Sample फाइल में पेस्ट कर दें और सेव कर लें, फिर अपलोड करें।</li>
                    <li>क्लास 1 से 10 तक एक फॉर्मेट है, इस बात का विशेष ध्यान रखें।</li>
                    <li>Excel में फॉर्मेट बदलने के लिए निम्न प्रक्रिया अपनाएं:</li>
                    <li style="background:black; color:yellow; width:100%; padding:20px;">
                      <ul type="circle">
                        <li>जन्म तिथि वाले कॉलम का चुनाव करके पूरे कॉलम को सेलेक्ट करें।</li>
                        <li>उस पर राइट क्लिक करके Format Cells का चुनाव करें।</li>
                        <li>Date वाले Option का चुनाव करें, Date के चुनाव के बाद Locale (Location) में English (United Kingdom) में 2001-03-14 को चुने और OK करें, फिर फाइल को सेव कर दें।</li>
                      </ul>
                    </li>
                    <li>फिर उस फाइल से डेटा एक-एक कॉलम का चुनाव करके Download Sample File में डालकर सेव करें और अपलोड करें।</li>
                    <h4>अधिक जानकारी के लिए 9460205006 पर कॉल करें (समय: सुबह 09:00 से शाम 7 बजे तक)</h4>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
