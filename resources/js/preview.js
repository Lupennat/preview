import IndexField from './components/IndexField';
import DetailField from './components/DetailField';

Nova.booting((app, store) => {
    app.component('index-preview', IndexField);
    app.component('detail-preview', DetailField);
});
