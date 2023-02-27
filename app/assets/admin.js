import './shared';
import './modules/admin';

// Assets
import './modules/admin/style.scss';

// naja ajax
import './ui/naja';

// Webpack HMR
if (module.hot) {
	module.hot.accept();
  }
