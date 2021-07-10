<x-app-layout>
    <x-slot name="title">{{ $board->title .' | Board' }}</x-slot>

    <div class="max-w-7xl py-12 mx-auto px-2">
        <div class="overflow-hidden">
            <div class="p-6">

                <div class="flex justify-between mb-3 items-center" x-data="{isModalActive: false}">
                    <div class="text-xl font-semibold">{{ $board->title }}</div>
                    <div>
                        <x-button buttonType="light" padding="px-2 sm:px-2.5" x-on:click="isModalActive = ! isModalActive">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <div>Add Task User</div>
                        </x-button>
                    </div>

                    <x-modal x-show="isModalActive" toggle="isModalActive" type="info">
                        <x-slot name="header">
                            <div id="modal-title">
                                <h3 class="text-md md:text-lg font-semibold leading-6text-gray-900">
                                    <span>Add Task User</span>
                                </h3>
                            </div>
                        </x-slot>
                        <x-slot name="body">
                            <div class="mt-5 md:mt-8 text-sm text-gray-500 space-y-2">
                                <form method="POST" action="{{ route('task_users.submit', $board) }}">
                                    @csrf

                                    <div class="flex">
                                        <x-input id="name" class="block w-full" type="text" name="name" :value="old('name')" placeholder="{{ __('Name') }}" required x-ref="name" autofocus />
                                        <x-button class="ml-3" type="submit">
                                            {{ __('Create') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </x-slot>
                    </x-modal>
                </div>

                <div class="flex space-x-3 tasks-container">

                    <input type="hidden" name="update_task_user_url">
                    <input type="hidden" name="update_url">
                    <input type="hidden" name="updating_task_id">

                    @if ($board->task_users->isEmpty())
                        <p class="text-gray-700 text-sm">No Task.</p>
                    @endif

                    @foreach ($board->task_users as $task_user)
                        <div class="w-1/3 bg-blue-50 border-2 border-blue-200 border-opacity-50 shadow-sm sm:rounded-lg task-user-container">
                            <input type="hidden" name="create_url" value="{{ route('tasks.submit', [$board, $task_user]) }}">
                            <div class="py-3 px-3">
                                <div class="task-user flex justify-between items-center pb-4" data-id="{{ $task_user->id }}">
                                    <div class="title text-md">
                                        {{ $task_user->name }}
                                    </div>
                                    <div class="actions">
                                        <button class="outline-none focus:outline-none delete-task-user" buttonType="danger-light" padding="px-1 py-1" data-id="{{ $task_user->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>


                                <div class="tasks space-y-2">
                                    @foreach ($task_user->tasks as $task)
                                        <div class="task py-2 px-3 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg cursor-pointer flex justify-between items-center" data-task-id="{{ $task->id }}">
                                            <div class="title">{{ $task->title }}</div>
                                            <div class="actions">
                                                <button class="outline-none focus:outline-none delete-task" buttonType="danger-light" padding="px-1 py-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
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
        function app(){
            return {
                deleteTask(){
                    console.log('hiii');
                }
            }
        }
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
                    deleteTask(update_url.val());
                }

                // Remove & empty inputs
                if(! $(e.target).hasClass('task')
                && ! $(e.target).hasClass('add-card-input')
                && ! $(e.target).hasClass('editing')
                && ! $(e.target).hasClass('add-card-button')){

                    // If not empty convert previous input to task
                    if($('#add-card-input').val() != ""){
                        convertInputToTask();
                    }

                    // force empty
                    $('.tasks-container').find('.task-input-container').remove();
                    update_url.val('');
                    updating_task_id.val('');
                }

                // If task user input
                if(! $(e.target).hasClass('task-user-input')
                && ! $(e.target).hasClass('title')
                && ! $(e.target).hasClass('editing')){
                    // If not empty convert previous input to task
                    if($('#task-user-input').val() == ""){
                        toastr.error('Task user name can\'t be empty.')
                    }else{
                        convertTaskUserInputToUser();
                    }
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
                    deleteTask(update_url.val());
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

                    value = $(this).find('.title').text().trim();

                    $(this).addClass('task-input-container').removeClass('py-2 px-3 task flex justify-between')

                    update_url.val(create_url + '/' + $(this).data('task-id'));
                    updating_task_id.val($(this).data('task-id'));

                    $(this).html('<input type="text" id="add-card-input" class="add-card-input border-1 border-blue-600 ring-blue-500 ring-1 rounded-md w-full" placeholder="Add card title" value="'+value+'"></div>')
                }
            });

            $('.task-user').on('click', function(){
                if(! $(this).hasClass('editing')){
                    $(this).addClass('editing');

                    var container = $('.tasks-container');
                    var update_task_user_url = container.find('[name=update_task_user_url]')
                    update_task_user_url.val($(location).attr("href") + '/task_users/' + $(this).data('id'));

                    value = $(this).find('.title').text().trim();
                    $(this).addClass('task-user-input-container').removeClass('task-user flex items-center justify-between')

                    $(this).html('<input type="text" id="task-user-input" class="task-user-input border-0 focus:border-b-2 focus:border-0 focus:ring-0 border-b-2 border-blue-600 h-8 text-sm bg-blue-50 ring-none w-full" placeholder="Add task user name" value="'+value+'"></div>')

                    $(this).find('input').focus()
                }
            });

            $(document).on('keyup', '#task-user-input', function(){
                var container = $(this).closest('.task-user-container');
                var update_task_user_url = $('body').find('[name=update_task_user_url]');

                $.ajax({
                    type: "PUT",
                    url: update_task_user_url.val() +'?_token=' + '{{ csrf_token() }}',
                    data: {'name': $(this).val()},
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

            $('.add-card-button').on('click', function(){
                // Enable all button first
                $('.add-card-button').prop('disabled', false);

                if($('#add-card-input') && $('#add-card-input').val() == "" && update_url.val() != "" && updating_task_id.val() != ""){
                    deleteTask(update_url.val());
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
                        tasks.append('<div class="bg-white border-b border-gray-200 shadow-sm sm:rounded-lg cursor-pointer task-input-container" data-task-id="'+data.task.id+'"><input type="text" id="add-card-input" class="add-card-input border-1 border-blue-600 ring-blue-500 ring-1 rounded-md w-full" placeholder="Add card title"></div>');

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

            // For normal tasks
            $('.delete-task').on('click', function(){
                var task = $(this).parents('.task');
                var container = task.closest('.task-user-container');
                var create_url = container.find('[name=create_url]').val();
                if(create_url){
                    deleteTask(create_url + '/' + task.data('task-id'));
                    task.remove();
                }
            });

            // For new tasks added
            $(document).on('click', '.actions .delete-task', function(){
                var task = $(this).parents('.task');
                var container = task.closest('.task-user-container');
                var create_url = container.find('[name=create_url]').val();
                if(create_url){
                    deleteTask(create_url + '/' + task.data('task-id'));
                    task.remove();
                }
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
                .addClass('task py-2 px-3 flex justify-between items-center')
                .html('<div class="title">'+value+'</div><div class="actions"><button class="outline-none focus:outline-none delete-task" buttonType="danger-light" padding="px-1 py-1"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button></div>')
        }

        function convertTaskUserInputToUser(){
            value = $('#task-user-input').val();
            $('#task-user-input')
                .closest('.task-user-input-container')
                .removeClass('task-user-input-container')
                .removeClass('editing')
                .addClass('task-user flex items-center justify-between')
                .html('<div class="title text-md">'+value+'</div><div class="actions"><button class="outline-none focus:outline-none delete-task-user" buttonType="danger-light" padding="px-1 py-1" data-id="'+$('#task-user-input').data('id')+'"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button></div>')
        }

        function deleteTask(url){
            hitAjax('DELETE', url);
        }

        $('.delete-task-user').on('click', function(){
            var container = $(this).closest('.task-user-container');
            var title = $(this).closest('.task-user').find('.title').text().trim();
            var url = $(location).attr("href")+'/task_users/'+$(this).data('id');

            $.ajax({
                type: 'GET',
                url: url +'?_token=' + '{{ csrf_token() }}',
                dataType: "json",
                success: function(data){
                    console.log(data);

                    var allowed = true;

                    if(data.task_user.tasks.length > 0){
                        allowed = confirm(title + ' has tasks in it. Are you sure?');
                    }

                    if(allowed){
                        hitAjax('DELETE', url);
                        container.remove();
                    }

                    if($('.tasks-container').find('div').length == 0){
                        $('.tasks-container').append('<p class="text-gray-700 text-sm">No Task.</p>')
                    }
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

        function hitAjax(type, url, data){

            if(type == 'DELETE'){
                console.log('Deleting - '+ url);
            }

            $.ajax({
                type: type,
                url:  url +'?_token=' + '{{ csrf_token() }}',
                data: data,
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
