# _plugins/category_tag_pagination.rb
module Jekyll
  class CategoryTagPageGenerator < Generator
    safe true

    def generate(site)
      per_page = site.config['pagination'] && site.config['pagination']['per_page'] || 4

      # Categories
      site.categories.each do |category, posts|
        generate_pages(site, posts, per_page, category, "categories", "category_index.html")
      end

      # Tags
      site.tags.each do |tag, posts|
        generate_pages(site, posts, per_page, tag, "tags", "tag_index.html")
      end
    end

    private

    def generate_pages(site, posts, per_page, name, type, layout)
      return if posts.empty?

      total_pages = (posts.size.to_f / per_page).ceil

      (1..total_pages).each do |page_num|
        site.pages << CategoryTagPage.new(site, site.source, name, posts, page_num, per_page, total_pages, type, layout)
      end
    end
  end

  class CategoryTagPage < Page
    attr_reader :paginator

    def initialize(site, base, name, posts, page_num, per_page, total_pages, type, layout)
      @site = site
      @base = base
      @dir  = page_num == 1 ? "#{type}/#{name}" : "#{type}/#{name}/page#{page_num}"
      @name = 'index.html'

      self.process(@name)
      self.read_yaml(File.join(base, '_layouts'), layout)

      self.data['title'] = name.capitalize
      self.data[type] = name  # Use "category" or "tag" key without singularize

      # Build paginator object
      self.data['paginator'] = {
        'page' => page_num,
        'per_page' => per_page,
        'posts' => posts.slice((page_num-1)*per_page, per_page) || [],
        'total_posts' => posts.size,
        'total_pages' => total_pages,
        'previous_page' => page_num > 1 ? page_num-1 : nil,
        'next_page' => page_num < total_pages ? page_num+1 : nil,
        'previous_page_path' => page_num > 2 ? "/#{type}/#{name}/page#{page_num-1}/" : "/#{type}/#{name}/",
        'next_page_path' => page_num < total_pages ? "/#{type}/#{name}/page#{page_num+1}/" : nil
      }
    end
  end
end
