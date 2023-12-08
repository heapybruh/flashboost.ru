function createHover(elementHover, content, elementToModify) {
    $(elementHover).hover(
        function() {
            $(elementToModify).text(content);
            $(elementToModify).stop().fadeTo(125, 1);
        },
        function() {
            $(elementToModify).stop().fadeTo(125, 0);
        }
    );
}

function createHovers(list) {
    list.forEach((object) => 
        createHover(object[0], object[1], object[2])
    );
}