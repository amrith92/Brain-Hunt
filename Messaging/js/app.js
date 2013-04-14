App = Ember.Application.create();

App.Router.map(function() {
  // put your routes here
	this.resource('dash', function() {
		this.resource('description', { path: ':description_id' }),
		this.resource('hints', { path: ':hints_id' }),
		this.resource('threads', function() {
			this.route('thread', { path: ':thread_id' });
		})
	});
});

Ember.Handlebars.registerBoundHelper('date', function(date) {
	return moment(date).fromNow();
});

var showdown = new Showdown.converter();

Ember.Handlebars.registerBoundHelper('markdown', function(input) {
	return new Ember.Handlebars.SafeString(showdown.makeHtml(input));
});

App.DashRoute = Ember.Route.extend({
	model: function() {
		var ret = Em.A();
		ret.pushObject(App.Dash.find(CookieManager.getItem('__cq')));
		return ret;
	}
});

App.ThreadsRoute = Ember.Route.extend({
	model: function() {
		return App.Thread.find();
	}
});

App.ThreadsThreadRoute = Ember.Route.extend({
	model: function(params) {
		alert("here");
		return App.Thread.find({ dash:  params.thread_id });
	}
});

App.MessagesRoute = Ember.Route.extend({
	model: function(params) {
		return App.Message.find({ thread: params.thread_id });
	}
});

App.ThreadsLayoutView = Ember.View.extend({
	layoutName: 'threadslayout'
});

App.PopupView = Ember.View.extend({
  layoutName: 'popup'
});

App.Store = DS.Store.extend({
	revision: 12,
	adapter: 'DS.FixtureAdapter'
});

App.Dash = DS.Model.extend({
	_id: DS.attr('string'),
	title: DS.attr('string'),
	description: DS.attr('string'),
	hints: DS.attr('string'),
	threads: DS.hasMany('App.Thread')
});

App.Dash.FIXTURES = [
	{ id: 1, _id: '1', title: 'Question One', description: 'This is question one', hints: '<ul><li>Hint1</li><li>Hint2</li><li>Hint3</li></ul>' },
	{ id: 2, _id: '2', title: 'Question Two', description: 'This is question two', hints: '<ul><li>Hint1</li><li>Hint2</li><li>Hint3</li></ul>' }
];

App.User = DS.Model.extend({
	_id: DS.attr('string'),
	handle: DS.attr('string')
});

App.User.FIXTURES = [
	{ id: 1, _id: '1', handle: 'amrith92' },
	{ id: 2, _id: '2', handle: 'test' }
];

App.Thread = DS.Model.extend({
	_id: DS.attr('string'),
	title: DS.attr('string'),
	user: DS.attr('number'),
	dash: DS.attr('number'),
	text: DS.attr('string'),
	timestamp: DS.attr('date')
});

App.Thread.FIXTURES = [
	{ id: 1, _id: '1', title: 'How to...', text: "Some shit", user: 1, dash: 1, timestamp: new Date() }
];

App.Message = DS.Model.extend({
	_id: DS.attr('string'),
  thread: DS.attr('number'),
	user: DS.attr('number'),
	text: DS.attr('string'),
	timestamp: DS.attr('date')
});

App.Message.FIXTURES = [
	{ id: 1, _id: '1', thread: 1, user: 1, text: 'Blah blah blah', timestamp: new Date() }
];
