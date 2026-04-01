<div class="card">
    <div class="card-header">
        <h4>Test Student Endpoints</h4>
    </div>
    <div class="card-body">
        <form id="apiForm">
            <div class="row">
                <div class="col-md-5">
                    <label for="studentId" class="form-label">Student ID <em class="form-text text-muted">This value will be sent via X-Authenticated-UserId header.</em></label>
                    <input type="text" class="form-control" id="studentId" placeholder="Enter Student Bilkent ID here...">
                    <div class="form-text text-muted">Please enter a valid Bilkent ID (e.g., 21202227, 22101862, 22501936)</div>
                </div>
                <div class="col-md-1">
                    <label for="httpMethod" class="form-label">HTTP Method</label>
                    <select class="form-select" id="httpMethod">
                        <option value="GET" selected>GET</option>
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="DELETE">DELETE</option>
                        <option value="PATCH">PATCH</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="apiUrl" class="form-label">API URL</label>
                    <select class="form-select" id="apiUrl">
                        <option value="/api-student/v1/profile" selected>TEST: /api-student/v1/profile</option>
                        <option value="/api-student/v1/photo">TEST: /api-student/v1/photo</option>
                        <option value="https://api.bilkent.edu.tr/student/v1/profile">PROD: https://api.bilkent.edu.tr/student/v1/profile</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary" id="sendBtn">Send Request</button>
                </div>
            </div>

        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>API Response</h4>
        <span id="statusBadge" class="badge"></span>
    </div>
    <div class="card-body">
        <pre id="responseOutput" class="bg-light p-3 border rounded" style="min-height: 100px; max-height: 800px; overflow: auto;">Response will appear here...</pre>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#apiForm').on('submit', function (e) {
            e.preventDefault();

            const studentId = $('#studentId').val().trim();
            const method = $('#httpMethod').val();
            const url = $('#apiUrl').val();

            $('#sendBtn').prop('disabled', true).text('Sending...');
            $('#responseOutput').text('Loading...');
            $('#statusBadge').removeClass('bg-success bg-danger bg-warning').text('');

            $.ajax({
                url: url,
                method: method,
                headers: {
                    //'Authorization': 'Bearer ' + token,
                    'X-Authenticated-UserId': studentId,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data, textStatus, xhr) {
                    //alert(JSON.stringify(data, null, 4));
                    $('#statusBadge').addClass('bg-success').text(xhr.status + ' ' + xhr.statusText);
                    $('#responseOutput').text(JSON.stringify(data, null, 4));
                },
                error: function (xhr) {
                    $('#statusBadge').addClass('bg-danger').text(xhr.status + ' ' + xhr.statusText);
                    let errorData;
                    try {
                        errorData = JSON.parse(xhr.responseText);
                    } catch (e) {
                        errorData = xhr.responseText;
                    }
                    $('#responseOutput').text(typeof errorData === 'object' ? JSON.stringify(errorData, null, 4) : errorData);
                },
                complete: function () {
                    $('#sendBtn').prop('disabled', false).text('Send Request');
                }
            });
        });
    });
</script>
