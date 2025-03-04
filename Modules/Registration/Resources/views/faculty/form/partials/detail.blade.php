<style>
.form-section{
    display: flex;
    column-gap: 10px;
}
form .form-section:last-child{
    border: none;
}
.form-section .form-group { 
    flex-basis: 100%;
}

.form-section .form-group{
    flex: 1;
}

.form-section .form-group:last-child{
    flex: 2;
}
input[type="time"] {
    height: 40px;
}
</style>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <input type="hidden" name="faculty_id" value="{{ $facultyId }}">

    <!-- Time/Room 1 -->
    <fieldset>
        
        <legend>Time/Room 1</legend>
        <div class="form-section">
        <div class="form-group">
            <label for="day_1">Day:</label>
            <select name="sessions[0][day]" id="day_1" class="form-control">
                <?php foreach(sessions_day_select() as $day): ?>
                    <option value="{{ $day['value'] }}" @if(!empty($sessions) && $sessions->day_1 == $day['value']) selected @endif>{{ $day['label'] }}</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="from_1">From:</label>
            <input type="time" name="sessions[0][from]" id="from_1" class="form-control" value="{{ $sessions->from_1 ?? '' }}">
        </div>

        <div class="form-group">
            <label for="to_1">To:</label>
            <input type="time" name="sessions[0][to]" id="to_1" class="form-control" value="{{ $sessions->to_1 ?? '' }}">
        </div>

        <div class="form-group">
        <label for="room_1">Room:</label>
        <select name="sessions[0][room]" id="room_1" class="form-control">
            <?php foreach(sessions_room_select() as $room): ?>
                <option value="{{ $room['value'] }}" @if(!empty($sessions) && $sessions->room_1 == $room['value']) selected @endif>{{ $room['label'] }}</option>
            <?php endforeach; ?>
        </select>
        </div>

        <div class="form-group">
            <label for="topic_1">Topic:</label>
            <input type="text" name="sessions[0][topic]" id="topic_1" class="form-control" value="{{ $sessions->topic_1 ?? '' }}">
        </div>
    </div>
    <div class="attach">
     {!! Form::attach('sessions[0][attachment]', $sessions->attach_1 ?? '', 0) !!}
    </div>
    </fieldset>

    <br/>

    <!-- Time/Room 2 -->
    <fieldset>
        <legend>Time/Room 2</legend>
        <div class="form-section">
        <div class="form-group">
            <label for="day_2">Day:</label>
            <select name="sessions[1][day]" id="day_2" class="form-control">
                <?php foreach(sessions_day_select() as $day): ?>
                    <option value="{{ $day['value'] }}" @if(!empty($sessions) && $sessions->day_2 == $day['value']) selected @endif>{{ $day['label'] }}</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="from_2">From:</label>
            <input type="time" name="sessions[1][from]" id="from_2" class="form-control" value="{{ $sessions->from_2 ?? '' }}">
        </div>

        <div class="form-group">
            <label for="to_2">To:</label>
            <input type="time" name="sessions[1][to]" id="to_2" class="form-control" value="{{ $sessions->to_2 ?? '' }}">
        </div>

        <div class="form-group">
            <label for="room_2">Room:</label>
            <select name="sessions[1][room]" id="room_2" class="form-control">
                <?php foreach(sessions_room_select() as $room): ?>
                    <option value="{{ $room['value'] }}" @if(!empty($sessions) && $sessions->room_2 == $room['value']) selected @endif>{{ $room['label'] }}</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="topic_2">Topic:</label>
            <input type="text" name="sessions[1][topic]" id="topic_2" class="form-control" value="{{ $sessions->topic_2 ?? '' }}">
        </div>
        </div>
        <div class="attach">
        {!! Form::attach('sessions[1][attachment]',  $sessions->attach_2 ?? '', 1) !!}
        </div>
    </fieldset>

      </div>
    </div>
    <!-- .row -->
  </div>
  <!--.card-body-->
</div>

<script type="text/javascript">
    $(document).ready(function() {
    document
        .querySelectorAll(".btn_attach")
        .forEach((button, buttonIndex) => {
          $(button).louisMedia({
            multiple: false,
            onSelectFiles: (files, $el) => {
              switch ($el.data("action")) {
                case "attachment":
                  let firstAttachment = _.first(files);
                  let $attachmentWrapper = $(
                    `.attachment-wrapper-${buttonIndex}`
                  );

                  $attachmentWrapper
                    .find(".attachment-url")
                    .val(firstAttachment.url);

                  $attachmentWrapper
                    .find(".attachment-details")
                    .html(
                      `<a href="${firstAttachment.full_url}" target="_blank">${firstAttachment.url}</a>`
                    );
                  break;
              }
            },
          });
        });
    });
</script>