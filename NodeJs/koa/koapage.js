const Koa = require('koa');
const puppeteer = require('puppeteer');
const devices = require('puppeteer/DeviceDescriptors');
const app = new Koa();
// 共享变量
let browser, page;
app.use(async (ctx, next) => {
    console.log(ctx.request.url, ctx.request.query);
    var myurl = ctx.request.url;
    var query = ctx.request.query;
    // 先开窗口
    if (myurl == '/new') {
        browser = await puppeteer.launch({
            headless: false
        });
        page = await browser.newPage();
        await page.goto('http://news.163.com');
    }
    // 再使用
    if (myurl == '/home') {
        await page.goto('https://www.ifeng.com');
    }
    // 关闭回收
    if (myurl == '/close') {
        await browser.close();
    }
    // 下一步
    await next();
    ctx.request.body = 'Hello Koa in app-async.js';
});
console.log("listen:3005");
app.listen(3005);