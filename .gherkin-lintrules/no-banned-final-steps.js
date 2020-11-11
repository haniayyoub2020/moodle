const gherkinUtils = require('gherkin-lint/dist/rules/utils/gherkin.js');
const rule = 'no-banned-final-steps';

const availableConfigs = {
  'Scenario': [],
  'ScenarioOutline': [],
};


function run(feature, unused, configuration) {
  const errors = [];

  if (!feature) {
    return errors;
  }

  const restrictedPatterns = getRestrictedPatterns(configuration);

  // Check the feature children
  feature.children.forEach(child => {
    if (!child.scenario) {
      return;
    }

    const steps = child.scenario.steps;
    checkStepNode(steps[steps.length - 1], child.scenario, feature, restrictedPatterns, errors);
  });

  return errors;
}

function getRestrictedPatterns(configuration) {
  // Patterns applied to everything; feature, scenarios, etc.
  let globalPatterns = (configuration.Global || []).map(pattern => new RegExp(pattern, 'i'));

  let restrictedPatterns = {};
  Object.keys(availableConfigs).forEach(key => {
    const resolvedKey = key.toLowerCase().replace(/ /g, '');
    const resolvedConfig = [].concat(availableConfigs[key], (configuration[key] || []));
    restrictedPatterns[resolvedKey] = resolvedConfig.map(pattern => new RegExp(pattern, 'i'));
    restrictedPatterns[resolvedKey] = restrictedPatterns[resolvedKey].concat(globalPatterns);
  });

  return restrictedPatterns;
}


function getRestrictedPatternsForNode(node, restrictedPatterns, language) {
  let key = gherkinUtils.getLanguageInsitiveKeyword(node, language).toLowerCase();

  return restrictedPatterns[key];
}

function checkStepNode(step, scenario, feature, restrictedPatterns, errors) {
  // Use the node keyword of the parent to determine which rule configuration to use
  getRestrictedPatternsForNode(scenario, restrictedPatterns, feature.language)
    .forEach(pattern => check(step, pattern, feature.language, errors));
}


function check(node, pattern, language, errors) {
  if (!node || !node.text) {
    return;
  }

  let strings = [node.text];
  const type = gherkinUtils.getNodeType(node, language);

  // We use trim() on the examined string because names and descriptions can contain 
  // white space before and after, unlike steps
  if (node.text.trim().match(pattern)) {
    errors.push({
      message: `${type}: "${node.text.trim()}" matches restricted pattern "${pattern}"`,
      rule: rule,
      line: node.location.line
    });
  }
}

module.exports = {
  name: rule,
  run: run,
  availableConfigs: availableConfigs
};
