
/**
 * Created by zhufy on 30.04.2017.
 */

function update(id, field, value) {
    $.ajax({
        url: "",
        type: "POST",
        data:
        '&id=' + id +
        '&field=' + field +
        '&value=' + value});
}