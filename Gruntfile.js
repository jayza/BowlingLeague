'use strict';

module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    project: {
      app: '.',
      assets: '<%= project.app %>/src/Frontend',
      css: [
        '<%= project.assets %>/scss/style.scss'
      ],
      js: [
        '<%= project.assets %>/js/*.js'
      ]    
    },
    sass: {
      dev: {
        options: {
          style: 'expanded',
          compass: true
        },
        files: {
          '<%= project.assets %>/css/style.css': '<%= project.css %>'
        }
      },
      dist: {
        options: {
          style: 'compressed',
          compass: true
        },
        files: {
          '<%= project.assets %>/css/style.css': '<%= project.css %>'
        }
      }
    },
    watch: {
      sass: {
        files: '<%= project.assets %>/scss/{,*/}*.{scss,sass}',
        tasks: ['sass:dev']
      }
    }
  });
  
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
  
  grunt.registerTask('default', [
    'sass:dev',
    'watch'
  ]);
};
