<x-app-layout>
    <x-slot name="title">{{ $board->title .' | Board' }}</x-slot>

    <div class="max-w-7xl py-12 mx-auto px-2">
        <div class="overflow-hidden">
            <div class="p-6">
                <div class="mb-3 text-xl font-semibold">{{ $board->title }}</div>
                <div class="flex space-x-3 tasks-container">

                    <input type="hidden" name="update_url">
                    <input type="hidden" name="updating_task_id">

                    @foreach ($board->task_users as $task_user)
                        <div class="w-1/3 bg-blue-50 border-2 border-blue-200 border-opacity-50 shadow-sm sm:rounded-lg task-user-container">
                            <input type="hidden" name="create_url" value="{{ route('tasks.submit', [$board, $task_user]) }}">
                            <div class="py-3 px-3">
                                <div class="text-md pb-4">
                                    {{ $task_user->name }}
                                </div>

                                <div class="tasks space-y-2">
                                    @foreach ($task_user->tasks as $task)
                                        <div class="task py-2 px-3 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg cursor-pointer" data-task-id="{{ $task->id }}">
                                            {{ $task->title }}
                                        </div>
                                    @endforeach
                                </div>

                                <div class="pt-8 text-center">
                                    <x-button id="add-card-button" class="add-card-button flex items-center justify-center text-white h-8 w-full" height="h-8">
                                        <div class="icon -mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                        <div class="text-sm uppercase tracking-widest">Add</div>
                                    </x-button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        var update_url = $('body').find('[name=update_url]');
        var updating_task_id = $('body').find('[name=updating_task_id]');

        $(document).ready(function() {

            $('html').click(function(e) {

                 // Delete task if empty
                if(! $(e.target).hasClass('add-card-input')
                && ! $(e.target).hasClass('add-card-button')
                && ! $(e.target).hasClass('task')
                && $('#add-card-input').val() == ""
                && update_url.val() != ""
                && updating_task_id.val() != ""
                ){
                    console.log('deleting');
                    deleteEmptyTask();
                }

                // Remove & empty inputs
                if(! $(e.target).hasClass('task')
                && ! $(e.target).hasClass('add-card-input')
                && ! $(e.target).hasClass('add-card-button')){

                    // If not empty convert previous input to task
                    if($('#add-card-input').val() != ""){
                        convertInputToTask();
                    }

                    // force empty
                    $('.tasks-container').find('.task-input-container').remove();
                    update_url.val('');
                    updating_task_id.val('');

                    console.log('Cliked Outside');
                }

                // Enable all buttons
                $('.tasks-container').find('.add-card-button').each(function(){
                    $(this).prop('disabled', false)
                });
            });

            $('.task').on('click', function(){

                if(! $(this).hasClass('editing')
                && $('#add-card-input')
                && $('#add-card-input').val() == ""
                && update_url.val() != ""
                && updating_task_id.val() != ""){
                    deleteEmptyTask();
                }

                if(! $(this).hasClass('editing') && $('#add-card-input') && $('#add-card-input').val() != ""){
                    console.log("in 1");
                    convertInputToTask();
                }

                // If editing task
                if(! $(this).hasClass('editing') && $(this).data('task-id') != ""){
                    $(this).addClass('editing');
                    var container = $(this).closest('.task-user-container');
                    var create_url = container.find('[name=create_url]').val();

                    // Remove & empty all existing inputs
                    $('.tasks-container').find('.task-input-container').remove();
                    update_url.val('');
                    updating_task_id.val('');

                    value = $(this).text().trim();

                    $(this).addClass('task-input-container').removeClass('py-2 px-3 task')

                    update_url.val(create_url + '/' + $(this).data('task-id'));
                    updating_task_id.val($(this).data('task-id'));

                    $(this).html('<input type="text" id="add-card-input" class="add-card-input border-1 border-blue-600 ring-blue-500 ring-1 rounded-md w-full" placeholder="Add card title" value="'+value+'"></div>')
                }

            });

            $('.add-card-button').on('click', function(){
                // Enable all button first
                $('.add-card-button').prop('disabled', false);

                if($('#add-card-input') && $('#add-card-input').val() == "" && update_url.val() != "" && updating_task_id.val() != ""){
                    deleteEmptyTask();
                }

                if($('#add-card-input') && $('#add-card-input').val() != ""){
                    convertInputToTask();
                }

                var container = $(this).closest('.task-user-container');
                var create_url = container.find('[name=create_url]').val();
                var tasks = $(this).closest('.task-user-container').find('.tasks')

                // Remove & empty all existing inputs
                $('.tasks-container').find('.task-input-container').remove();

                update_url.val('');
                updating_task_id.val('');

                // Disable current button
                container.find('.add-card-button').prop('disabled', true);

                // Create empty task with empty input
                $.ajax({
                    type: "POST",
                    url: create_url +'?_token=' + '{{ csrf_token() }}',
                    data: {'title': ""},
                    dataType: "json",
                    success: function(data){
                        console.log(data);
                        update_url.val(create_url + '/' + data.task.id);
                        updating_task_id.val(data.task.id);

                        // Create empty input
                        tasks.append('<div class="bg-white border-b border-gray-200 shadow-sm sm:rounded-lg cursor-pointer task-input-container"><input type="text" id="add-card-input" class="add-card-input border-1 border-blue-600 ring-blue-500 ring-1 rounded-md w-full" placeholder="Add card title"></div>');

                        tasks.find('input').focus();
                    },
                    error: (data) => {
                        if(data.responseJSON && data.responseJSON.message) {
                            console.log(data.responseJSON.message);
                        }else{
                            console.log(data);
                        }
                    }
                });
            });

            // Update task
            $(document).on('keyup','#add-card-input', function(){
                var container = $(this).closest('.task-user-container');
                var create_url = container.find('[name=create_url]').val();
                var update_url = $('body').find('[name=update_url]');
                var updating_task_id = $('body').find('[name=updating_task_id]');

                $.ajax({
                    type: "PUT",
                    url: update_url.val() +'?_token=' + '{{ csrf_token() }}',
                    data: {'title': $(this).val()},
                    dataType: "json",
                    beforeSend: function(){
                    },
                    success: function(data){
                        console.log(data);
                    },
                    error: (data) => {
                        console.log(data);

                        if(data.responseJSON && data.responseJSON.message) {
                            console.log(data.responseJSON.message);
                        }
                    }
                });
            });
        });

        function convertInputToTask(){
            value = $('#add-card-input').val();
            $('#add-card-input')
                .closest('.task-input-container')
                .removeClass('task-input-container')
                .removeClass('editing')
                .addClass('py-2 px-3')
                .text(value);
        }

        function convertTaskToInput(task){
            // console.log(task);
            // value = task.text().trim();
            // console.log(value);
            // task.addClass('task-input-container converted-into-input')
            //     .removeClass('py-2 px-3 task')
            //     .html('<input type="text" id="add-card-input" class="add-card-input border-1 border-blue-600 ring-blue-500 ring-1 rounded-md w-full" placeholder="Add card title" value="'+value+'"></div>')
        }

        function deleteEmptyTask(){
            $.ajax({
                type: "DELETE",
                url:  update_url.val() +'?_token=' + '{{ csrf_token() }}',
                data: {'title': ""},
                dataType: "json",
                success: function(data){
                    console.log(data);
                },
                error: (data) => {
                    if(data.responseJSON && data.responseJSON.message) {
                        console.log(data.responseJSON.message);
                    }else{
                        console.log(data);
                    }
                }
            });
        }
    </script>
</x-app-layout>
