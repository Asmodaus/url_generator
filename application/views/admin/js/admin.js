let id=0;
let init_url='/ajax/admin_open';

function admin_open(div,new_id)
{
    id=new_id;
    fetch(init_url+'?id='+new_id+'&div='+(div.replace(/#/, '')), {
        method: 'GET', // POST, PUT, ...
        headers: {
            "Content-Type": "application/json",
            // и/или другие заголовки если надо
        },
        // body: JSON.stringify(someObject) // раскоментировать эту строку если нужно отправляеть запрос с JSON-ом
    })
        .then(res => {
            if (res.ok) {
                res.json().then(data => {
                    // data — это распарсеный JSON в виде JS объекта
                    insertComponents(data,div);
                });
            } else {
                console.log('Ответ от сервера не OK (отличный от 200).');
            }
        });
}

function insertComponents(data,div)
{
    if (data?.constructor.name !== 'Object')
    {
        console.error('Невалидный JSON:');
        console.info(data);
        return;
    }
 
    data.forEach(component => {
        var parent = $(div);
        var element = parent.select(component.name);
            if (element)
            {
                if (component.param== 'text')
                      element.innerHTML=component.text;
                else if (component.param== 'remove')
                      element.removeAttribute(component.text);
                else if (component.param== 'value')
                        element.value=component.text;
                else if (component.param=='add_class')
                      element.classList.add( component.text);
                else if (component.param=='remove_class')
                      element.classList.remove( component.text);
                else
                     element.setAttribute(component.param, component.text);
            }
            else  console.log('not find '+component.name);

    });
            
        
}