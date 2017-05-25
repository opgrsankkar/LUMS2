 $(function () {
            $(".demo1").bootstrapNews({
                newsPerPage: 3,
                autoplay: true,
                pauseOnHover: true,
                direction: 'up',
                newsTickerInterval: 4000,
                onToDo: function () {
                    //console.log(this);
                }
            });

            $(".demo2").bootstrapNews({
                newsPerPage: 2,
                autoplay: true,
                pauseOnHover: true,
                navigation: false,
                direction: 'down',
                newsTickerInterval: 10000,
                onToDo: function () {
                    //console.log(this);
                }
            });

            $("#demo3").bootstrapNews({
                newsPerPage: 3,
                autoplay: false,

                onToDo: function () {
                    //console.log(this);
                }
            });
        });