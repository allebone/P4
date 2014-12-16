@if (count($tasks) > 0)
@foreach($tasks as $key => $value)
<tr class="show_modal {{$value->completed == 0 ? 'incomplete' : 'complete'}}" style='cursor:pointer;' data-toggle="modal"  data-target="#abc" id='show_modal' taskid="{{ URL::route('task_show',$value->id) }}">                            
    <td>{{ str_limit($value->title, $value->completed == 0 ? $limit = 80 : $limit = 88, $end = '...') }}</td>
    <td>{{ date('d-m-Y H:i',strtotime($value->start_date)) }}</td>                            
    <td>@if($value->end_date != NULL){{ date('d-m-Y H:i',strtotime($value->end_date)) }}@else{{ '-----' }}@endif</td>                            
    <td>
        <div class="btn-group btn-group-sm" role="group" aria-label="...">
<!--            <button type="button" title='View Task' class="btn btn-info show_modal" data-toggle="modal"  data-target="#abc" id='show_modal' taskid="{{ URL::route('task_show',$value->id) }}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>-->
            <button type="button" taskid="{{ URL::route('task_edit',$value->id) }}" class="btn btn-default edit_modal" data-toggle="modal" title='Edit Task'  data-target="#abc" id='edit_modal'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>                        
            <button id='delete_task' title='Delete Task' taskid="{{ URL::route('task_delete',$value->id) }}"  type="button" class="delete_task btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        </div>                
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="6" style="text-align: center;">No Tasks At This Moment</td>
</tr>
@endif