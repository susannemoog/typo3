const path = require('path');

const suffix = '.js';

const isContrib = (importValue) => {
  try {
    return require.resolve(importValue) !== '';
  } catch (e) {
    return false;
  }
};

const mapImport = (targetModule, context) => {

  if (isContrib(targetModule)) {
    return targetModule;
  }

  if (targetModule.charAt(0) === '.') {
    targetModule = path
      .resolve(path.dirname(context), targetModule)
      .replace(/^.*\/Build\/JavaScript\/([^\/]+?)\/Resources\/Public\/TypeScript/, (match, extname) => 'TYPO3/CMS/' + ('_' + extname).replace(/_./g, (e) => e.charAt(1).toUpperCase()));
  }

  return targetModule + suffix;
};

const mapImports = (source, srcpath, imports) => {
  try {
    let offset = 0;
    imports.map(i => {
      if (i.d === -2) {
      } else if (i.d > -1) {
        const importExpr = source.substring(i.s + offset, i.e + offset);
        // dynamic import, check if static string and map import in that case
        if (importExpr.match(/^['"][^'"]+['"]$/)) {
          const importValue = source.substring(i.s + offset + 1, i.e + offset - 1);
          const mappedValue = mapImport(importValue, srcpath);
          if (mappedValue !== importValue) {
            source = source.substring(0, i.s + 1 + offset) + mappedValue + source.substring(i.e - 1 + offset)
            offset += mappedValue.length - importValue.length;
          }
        }
      } else {
        // static import, will always be a static string
        const importValue = source.substring(i.s + offset, i.e + offset);
        const mappedValue = mapImport(importValue, srcpath);
        if (mappedValue !== importValue) {
          source = source.substring(0, i.s + offset) + mappedValue + source.substring(i.e + offset)
          offset += mappedValue.length - importValue.length;
        }
      }
    });
  } catch (e) {
    console.error(e);
    return source;
  }
  return source;
};

exports.isContrib = isContrib;
exports.mapImport = mapImport;
exports.mapImports = mapImports;
