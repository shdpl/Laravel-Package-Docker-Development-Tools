(function ($) {
    const postMessage = (data) => parent.postMessage(data, "*");
    const resizeObserver = new ResizeObserver((entries) =>
        postMessage({ iFrameHeight: entries[0].contentRect.height })
    );

    ns.init = function () {
        ns.$ = H5P.jQuery;
        ns.basePath = H5PIntegration.editor.libraryUrl;
        ns.fileIcon = H5PIntegration.editor.fileIcon;
        ns.ajaxPath = H5PIntegration.editor.ajaxPath;
        ns.filesPath = H5PIntegration.editor.filesPath;
        ns.apiVersion = H5PIntegration.editor.apiVersion;
        ns.copyrightSemantics = H5PIntegration.editor.copyrightSemantics;
        ns.assets = H5PIntegration.editor.assets;
        ns.baseUrl = H5PIntegration.baseUrl;
        ns.metadataSemantics = H5PIntegration.editor.metadataSemantics;
        if (H5PIntegration.editor.nodeVersionId !== undefined) {
            ns.contentId = H5PIntegration.editor.nodeVersionId;
        }

        const $editor = $("#laravel-h5p-editor");
        const $params = $("#laravel-h5p-parameters");
        const $library = $("#laravel-h5p-library");
        const library = $library.val();
        const h5peditor = new ns.Editor(library, $params.val(), $editor[0]);

        H5P.externalDispatcher.on("xAPI", (event) => postMessage(event));
        H5P.externalDispatcher.on("resize", (event) => postMessage(event));

        resizeObserver.observe(document.querySelector(".h5p-editor-iframe"));

        $("#laravel-h5p-form").submit(function () {
            console.log(h5peditor.getParams(), h5peditor.getLibrary());
            return false;
        });
    };
    ns.getAjaxUrl = function (action, parameters) {
        var url = H5PIntegration.editor.ajaxPath + action;
        if (parameters !== undefined) {
            var separator = url.indexOf("?") === -1 ? "?" : "&";
            for (var property in parameters) {
                if (parameters.hasOwnProperty(property)) {
                    url += separator + property + "=" + parameters[property];
                    separator = "&";
                }
            }
        }
        return url;
    };
    $(document).ready(ns.init);
})(H5P.jQuery);
