<div class="row">
    <div class="col-lg-4">
        <table>
            <tbody>
                <tr>
                    <td class="font-weight-bold">Evidence: </td>
                    <td>: {{$inspection->evidence ? "Uploaded" : "Waiting for Upload"}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Evidence Verification </td>
                    <td>: {!!$inspection->verify_evidence ? "<i class=' fas fa-check text-success'></i>" : "<i class=' fas fa-times text-danger'></i>"!!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>