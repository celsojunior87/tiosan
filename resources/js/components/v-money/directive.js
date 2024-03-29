import { format, setCursor } from './utils';
import opt from './options';

function run(el, eventName, config) {
  let positionFromEnd = el.value.length - el.selectionEnd;
  el.value = format(el.value, config);
  positionFromEnd = el.value.length - positionFromEnd;
  positionFromEnd = Math.max(positionFromEnd, config.prefix.length + 1); // left
  setCursor(el, positionFromEnd);
  el.dispatchEvent(new Event(eventName));
}

function getInput(el) {
  if (el.tagName.toLocaleUpperCase() !== 'INPUT') {
    const els = el.getElementsByTagName('input');
    if (els.length !== 1)
      throw new Error(`v-money requires 1 input, found ${els.length}`);
    else
      el = els[0];
  }
  return el;
}

function getConfig(binding) {
  const config = opt;
  if (binding.value && binding.value.precision) {
    const precision = binding.value.precision;
    if (typeof precision === 'number' && precision > 0 && precision < 6 && precision === parseInt(precision, 10))
      config.precision = precision;
  }
  return config;
}

function componentUpdated(el, binding, vnode, oldVnode) {
  // Prevent firing endless events
  const data = vnode.data.props || vnode.data.model;
  const oldData = oldVnode.data.props || oldVnode.data.model;
  if (data && data.value === oldData.value) return;

  el = getInput(el);
  el.value = data ? data.value : el.value;
  run(el, 'input', getConfig(binding));
}

export default { componentUpdated };
