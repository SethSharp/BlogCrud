# Release notes

## Upgrade Guide from 1.0 to 2.0
- Namespace for `SethSharp\BlogCrud\Models\File` has changed to `SethSharp\BlogCrud\Models\Blog`
- With the changes from [PR#5](https://github.com/SethSharp/BlogCrud/pull/5), I suggest writing a command going through all blog comments then update the comment relationship column `blog_id` to the current blog... then drop `blog_comments`
- 

## V2.0
- Moves File to proper location under `Models/Blog/` [Pull Request #3](https://github.com/SethSharp/BlogCrud/pull/3)
- Add missing size rules in requests [Pull Request #4](https://github.com/SethSharp/BlogCrud/pull/4)
- Change how Comment model relationships and tables work [Pull Request #5](https://github.com/SethSharp/BlogCrud/pull/5)