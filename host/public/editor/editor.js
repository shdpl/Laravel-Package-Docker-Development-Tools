console.log("hi");

let H5PIntegration;

const loadScriptsInSeq = (arr, index = 0) => {
    if (!arr[index]) {
        return;
    }
    loadScript(arr[index], () => {
        index++;
        loadScriptsInSeq(arr, index);
    });
};

const loadScript = (url, onloadFunction) => {
    const newScript = document.createElement("script");
    newScript.onerror = (oError) => {
        throw new URIError(
            "The script " + oError.target.src + " didn't load correctly."
        );
    };
    newScript.onload = onloadFunction;
    newScript.src = url;
    document.head.appendChild(newScript);
};

const loadStyles = (styles) => {
    for (let style of styles) {
        const newStyle = document.createElement("link");
        newStyle.rel = "stylesheet";
        newStyle.href = style;
        document.head.appendChild(newStyle);
    }
};

const initData = (data) => {
    console.log("data", data);
    H5PIntegration = window.H5PIntegration = data;
    loadScriptsInSeq(data.core.scripts);
    loadStyles(data.core.styles);
    /**
     * @foreach($settings['core']['scripts'] as $script)
{{ Html::script($script) }}
@endforeach
     */
};

fetch("http://localhost:1000/api/hh5p/editor")
    .then((response) => response.json())
    .then((data) => initData(data));
