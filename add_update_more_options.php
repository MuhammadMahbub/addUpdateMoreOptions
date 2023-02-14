
<!--######## Add more options HTML Code ###### -->
<div class="form-group">
    <label> Options <span class="text-danger">*</span></label>
    <div class="row new_properties mb-1">
        <div class="col-10">
            <input type="text" class="form-control" name="option[]" placeholder="">
        </div>
        <div class="col-2">
            <button type="button" class="close remove--new_properties">
                <span>&times;</span>
            </button>
        </div>
    </div>
    <div class="properties-container"></div>
    <div class="btn btn-info mt-1" id="add_more">Add More</div>
</div>

<div class="form-group">
    <input type="submit" class="form-control btn btn-primary" value="Add Question">
</div>
<!--######## Add more options HTML Code ###### -->


<!--######## Add more options JS Code ###### -->
<script>
    $(document).ready(function () {
        $('#add_more').click(function (){
            // alert('hi');
            let new_properties_html =
            `<div class="row new_properties">
                <div class="col-10">
                    <input type="text" name="option[]" class="form-control mb-1">
                </div>
                <div class="col-2">
                <button type="button" class="close remove--new_properties">
                    <span>&times;</span>
                </button>
                </div>
            </div>`;
            $('.properties-container').append(new_properties_html);
        });
        $(document).on('click', '.remove--new_properties', function(){
            $(this).closest(".new_properties").remove();
        }); 
    });
</script>
<!--######## Add more options JS Code ###### -->


<!--######## Edit more options HTML Code ###### -->
<div class="form-group">
    <label> Options <span class="text-danger">*</span></label>
    @foreach ($que_opt as $item)
    <div class="row new_properties">
        <div class="col-10">
            <input type="text" class="form-control mb-1 delete_option" value="{{$item->option}}" name="option[]" placeholder="">
        </div>
        <div class="col-2">
            <button type="button" class="close remove--new_properties">
                <span class="option_delete" data-id="{{ $item->id }}" >&times;</span>
            </button>
        </div>
    </div>
    @endforeach
    <div class="properties-container"></div>
    <div class="btn btn-info mt-1" id="add_more">Add More</div>
</div>

<div class="form-group">
    <input type="submit" class="form-control btn btn-primary" value="Edit Question">
</div>
<!--######## Edit more options HTML Code ###### -->


<!--######## Edit Delete more options JS Code ###### -->
<script>
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $(document).ready(function () {
        //Delete with With Click cross btn 
        $(".option_delete").click(function(){
            let id = $(this).attr('data-id');
             
            $.ajax({
                type: "get",
                url: "/questionOption/delete"+'/'+id,
                success: function (data) {
                    console.log(data)
                },
                error: function (data) {
                    console.log('Error:', data);
            }
            })
        })
        //Delete with With Click cross btn


        $('#add_more').click(function (){
            // alert('hi');
            let new_properties_html =
            `<div class="row new_properties">
                <div class="col-10">
                    <input type="text" name="option[]" class="form-control mb-1">
                </div>
                <div class="col-2">
                <button type="button" class="close remove--new_properties">
                    <span>&times;</span>
                </button>
                </div>
            </div>`;
            $('.properties-container').append(new_properties_html);
        });
        $(document).on('click', '.remove--new_properties', function(){
            $(this).closest(".new_properties").remove();
        });
        
    });
</script>
<!--######## Edit Delete more options JS Code ###### -->


<!--######## Add more options Controller Code ###### -->
foreach($request->option as $key=>$opt){
    QuestionOption::insert([
        'option' => $request->option[$key],
        'question_id' => $cat->id,
        'created_at' => Carbon::now()
    ]);
}
<!--######## Add more options Controller Code ###### -->


<!--######## Edit with Add more options Controller Code ###### -->
// for multiple option update settings
foreach($que_opt as $index => $value){ 
    QuestionOption::find($value->id)->update([
        'option' => $request->option[$index]
    ]);
}  

// for new value insert
foreach($request->option as $key=>$value){ 
    $newOptions = QuestionOption::firstOrNew (
        ['option' =>  $request->option[$key] ],
        ['question_id' => $cat->id ]
    );
    $newOptions->save(); 
}
<!--######## Edit with Add more options Controller Code ###### -->


<!--######## Delete with With Click cross btn ###### -->
public function questionOptionDelete($id) {
    QuestionOption::findOrFail($id)->delete();
    return response(['success' => 'data delete success']);
}
<!--######## Delete with With Click cross btn ###### -->
              