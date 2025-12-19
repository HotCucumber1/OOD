import React from 'react';
import ReactDOM from 'react-dom/client';
import {App} from './App';
import {DocumentModel} from "./Editor/Model/Entity/DocumentModel";
import {JsonSaver} from "./Editor/Model/Service/JsonSaver";

const model = new DocumentModel(new JsonSaver());

ReactDOM.createRoot(document.getElementById('root')!).render(
    <React.StrictMode>
        <App
            model={model}
            canvasId={'slide1'}
        />
        {/*<App*/}
        {/*    model={model}*/}
        {/*    canvasId={'slide2'}*/}
        {/*/>*/}
    </React.StrictMode>
);
