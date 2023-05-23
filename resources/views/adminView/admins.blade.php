@extends('layouts.adminLayout')

@section('page title')
    Administrators
@endsection

@section('content')
    <div class="col-sm-7">
        <a href="/admin/add-admin">Add Administrator</a>
    </div>
    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Data Table</strong>
                            <button onclick="downloadTableAsPdf()" class="btn btn-success ml-3" style="border-radius: 15px">Export PDF</button>
                        </div>

                        <div class="card-body">
                            <table id="bootstrap-data-table-export-admins" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Phone number</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $c = 1;
                                    ?>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $c++ }}</td>
                                            <td>{{ $admin->first_name }} {{ $admin->first_name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->username }}</td>
                                            <td>{{ $admin->phone_number }}</td>
                                            <td>
                                                @if (Auth::user()->id != $admin->id)
                                                    <a onclick="return confirm('Are you sure to delete Dr.{{ $admin->first_name }}  {{ $admin->last_name }}')"
                                                        class="text text-danger"
                                                        href="/admin/delete-admin/{{ $admin->id }}">Delete</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadTableAsPdf() {
        // Retrieve the table element
        var originalTable = document.getElementById("bootstrap-data-table-export-admins");

        // Clone the table element
        var clonedTable = originalTable.cloneNode(true);

        // Exclude the last column in the cloned table
        var lastColumnIndex = clonedTable.rows[0].cells.length - 1;
        for (var i = 0; i < clonedTable.rows.length; i++) {
            clonedTable.rows[i].deleteCell(lastColumnIndex);
        }

        // Create configuration options for html2pdf
        var options = {
            filename: 'all-administrators.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        // Use html2pdf to generate the PDF from the modified cloned table
        html2pdf().from(clonedTable).set(options).save();
    }
</script>
@endsection