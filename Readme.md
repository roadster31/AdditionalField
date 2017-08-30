# Additional Field

This module adds an input field to the right column of general tab of products, categories, folders and contents. This
value is internationalized: you can enter a value for each language your shop supports.

To use additional values in front office, use the `additional_field.get` loop. `object_id` is the required object ID, and
 `source` is the object type (`product`, `content`, `folder` or `category`): 

    {loop type="additional_field.get" name="infosup" object_id=$ID source="content"}
        <p>Additional information: {$ADDITIONAL_FIELD_1}</p>
    {/loop}
