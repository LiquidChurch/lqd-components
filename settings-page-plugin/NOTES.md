# Notes

# Introduction

# Notes
## Note 1
Ideally with `get_option()` we should be able to pass a second parameter that contains a default value if no value
is found in the database.

For unknown reasons passing an empty array as the second parameter to `get_option()` does not return an array as
expected but an empty string. This becomes problematic when we later use `in_array()` to check if a given term is in
`$selected_taxonomies` as `in_array()` expects an array as its second parameter.

This appears to be a dilemma caused by `get_option()` itself and not passing an empty array to variable. In plain
old PHP passing an empty array to a new variable results in the new variable being an array as well.

To avoid this problem we check if `$selected_taxonomies` is an array and place the result in a variable
(`$is_selected_an_array`). We then check with every iteration of our `foreach` whether `$is_selected_an_array` is
true or false and if it is true then we jump ahead to our checked checkbox output.

While it would be ideal to only check once if `$selected_taxonomies` is an array the complexity added by using a
`if` statement to implement this was not worth the idealism. A compromise is that we are performing the actual
`is_array()` function only once and then in our `foreach` we only need to read `$is_selected_an_array`'s value.

The computation time saved by optimizing this is not noticeable and thus not worth the effort.