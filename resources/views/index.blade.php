@extends('layout')

@section('content')
<h1 class="mb-4 text-center">📋 Daftar Tugas</h1>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-3">
    <!-- Filter Status -->
    <div class="d-flex align-items-center gap-2">
        <label for="statusFilter" class="form-label mb-0">Filter Status:</label>
        <select id="statusFilter" class="form-select d-inline-block" style="width:180px;">
            <option value="">Semua</option>
            <option value="To-Do">To-Do</option>
            <option value="In Progress">In Progress</option>
            <option value="Done">Done</option>
        </select>
    </div>

    <!-- Tambah Tugas -->
    <div>
        <button type="button" id="addToDoBtn" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Tugas
        </button>
    </div>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle" id="taskTable" style="width:100%">
        <thead class="table-dark text-center">
            <tr>
                <th style="width:5%;">#</th>
                <th>Judul Tugas</th>
                <th>Deskripsi</th>
                <th style="width:12%;">Status</th>
                <th style="width:15%;">Batas Waktu</th>
                <th style="width:15%;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal Reusable -->
<x-todo-modal id="todoModal" title="Tambah Tugas"/>
@endsection

@push('scripts')


<script>
$(document).ready(function() {
    let todoModal = new bootstrap.Modal(document.getElementById('todoModal'));
    let saveMethod = 'add';

    // DataTable
    let table = $('#taskTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('todo.data') }}',
            data: function(d) {
                d.status = $('#statusFilter').val();
            }
        },
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title', orderable: false },
            { data: 'description', name: 'description', orderable: false },
            {
              data: 'status',
              name: 'status',
              orderable: false,
              searchable: false,
              render: (status) => {
                let badgeClass = "bg-secondary";
                if (status === "In Progress") badgeClass = "bg-warning text-dark";
                if (status === "Done") badgeClass = "bg-success";

                return `
                  <div class="text-center">
                    <span class="badge ${badgeClass}">${status}</span>
                  </div>`;
              }
            },
            {
              data: 'due_date',
              name: 'due_date',
              orderable: true,
              render: (due_date) => {
                let dt = new Date(due_date);
                let formatted = `${String(dt.getDate()).padStart(2,'0')}-${String(dt.getMonth()+1).padStart(2,'0')}-${dt.getFullYear()} ${String(dt.getHours()).padStart(2,'0')}:${String(dt.getMinutes()).padStart(2,'0')}`;

                return due_date != null? formatted : "";
              }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: (row) => {
                    return `
                      <div class="text-center">
                        <button class="btn btn-sm btn-warning editTask" data-id="${row.id}">Perbarui</button>
                        <button class="btn btn-sm btn-danger deleteTask" data-id="${row.id}">Hapus</button>
                      </div>`;
                }
            }
        ],order: [[4, 'asc']], 
    });

    // Filter status
    $('#statusFilter').change(() => {
        table.ajax.reload();
    });

    // Show modal untuk tambah
    $('#addToDoBtn').click(() => {
        $('#toDoForm')[0].reset();
        $('#todo_id').val('');
        $('#todoModalLabel').text("Tambah Tugas");
        $('#saveBtn').text("Simpan");
        todoModal.show();
        saveMethod = 'add';
    });

    
    // Edit task
    $('#taskTable').on('click', '.editTask', function() {
        let rowData = table.row($(this).closest('tr')).data();

        $('#todo_id').val(rowData.id);
        $('#title').val(rowData.title);
        $('#description').val(rowData.description);
        $('#status').val(rowData.status);
        $('#due_date').val(rowData.due_date ? rowData.due_date.replace(' ', 'T') : '');

        $('#todoModalLabel').text("Perbarui Tugas");
        $('#saveBtn').text("Perbarui");
        saveMethod = 'edit';
        todoModal.show();
    });

    // Submit form
    $('#toDoForm').submit(function(e) {
        e.preventDefault();

        const id = $('#todo_id').val();
        const url = saveMethod === 'add' ? "{{ route('todo.store') }}" : `/todo-update/${id}`;
        const type = saveMethod === 'add' ? 'POST' : 'PUT';

        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(res) {
                $('#toDoForm')[0].reset();
                todoModal.hide();
                table.ajax.reload(null, false);
                Swal.fire({
                  title: res.message,
                  icon: "success",
                  draggable: true
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                Swal.fire({
                  title: "Gagal dalam mengolah data!",
                  icon: "error",
                  draggable: true
                });
            }
        });
    });

    $('#taskTable').on('click', '.deleteTask', function() {
      let id = $(this).data('id');

      Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
        confirmButtonText: "Yes, Hapus!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "/todo-delete/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
              table.ajax.reload(null, false);
              Swal.fire({
                title: "Terhapus!",
                text: res.message,
                icon: "success"
              });
            },
            error: function(xhr) {
              console.log(xhr.responseText);
              Swal.fire({
                title: "Gagal menghapus data!",
                icon: "error",
                draggable: true
              });
            }
          });
        }
      });
    });

});
</script>
@endpush
